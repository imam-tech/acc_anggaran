<?php

namespace App\Repositories;

use App\Models\Coa;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesAttachment;
use App\Models\SalesJournal;
use App\Models\SalesPayment;
use App\Models\SalesPaymentAttachment;
use App\Models\SalesPaymentJournal;
use App\Models\SalesProduct;
use App\Models\Tax;
use App\Services\DigitalOceanService;
use Illuminate\Support\Facades\DB;

class SalesRepository {

    public function storeCustomer($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SC: " . collect($validator->errors()->all())->implode(" , "));

            $message = "Creating";
            if ($data['id']) {
                $customer = Customer::find($data['id']);
                if (!$customer) return resultFunction("Err code SR-SC: customer not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $customer = new Customer();
                $customer->company_id = $companyId;
            }
            $customer->name = $data['name'];
            $customer->email = $data['email'];
            $customer->phone = $data['phone'];
            $customer->identity_number = $data['identity_number'];
            $customer->npwp_number = $data['npwp_number'];
            $customer->address = $data['address'];
            $customer->save();

            return resultFunction($message . " customer is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SC: catch " . $e->getMessage());
        }
    }

    public function detailCustomer($id) {
        try {
            $customer = Customer::find($id);
            if (!$customer) return resultFunction("Err code SR-DU: customer not found");

            return resultFunction("", true, $customer);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-DU: catch " . $e->getMessage());
        }
    }

    public function store($request, $companyId) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, [
                "customer_id" => 'required',
                "transaction_date" => 'required',
                'due_date' => 'required',
                "products" => 'required',
            ]);


            if ($validator->fails()) return resultFunction("Err code SR-S: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $customer = Customer::find($data['customer_id']);
            if (!$customer) return resultFunction("Err code SR-S: customer not found for ID " . $data['customer_id']);

            $message = "Creating";
            if ($data['id']) {
                $sales = Sales::find($data['id']);
                if (!$sales) return resultFunction("Err code SR-S: sales not found for ID " . $data['id']);
                $message = 'Updating';

                SalesProduct::where('sales_id', $sales->id)->delete();
                SalesJournal::where('sales_id', $sales->id)->delete();
            } else {
                $sales = new Sales();
                $sales->company_id = $companyId;
                $sales->transaction_number = '';
                $sales->payment_amount_total = 0;
            }
            $sales->customer_id = $customer->id;
            $sales->customer_email = $data['customer_email'];
            $sales->billing_address = $data['billing_address'];
            $sales->transaction_date = $data['transaction_date'];
            $sales->due_date = $data['due_date'];
            $sales->message = $data['message'];
            $sales->sub_total = 0;
            $sales->grand_total = 0;
            $sales->save();
            $sales->transaction_number = "Sales Invoice #" . $sales->id;
            $data['products'] = json_decode($data['products'], true);

            $products = Product::with([])
                ->whereIn('id', array_column($data['products'], 'id'))
                ->get();

            $salesProductInput = [];
            $salesJournalData = [];
            $salesJournalData[] = [
                'sales_id' => $sales->id,
                'account_id' => 2388,  // sementara account payable
                'debit' => 0,
                'credit' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $salesJournalTaxData = [];
            $subTotalFinal = 0;
            $taxTotalFinal = 0;
            foreach ($data['products'] as $productInput) {
                $selectProduct = $products->where('id', $productInput['id'])->first();
                if (!$selectProduct) return resultFunction("Err code SR-S: product db is not found");

                $subTotal = $productInput['quantity'] * $productInput['unit_price'];
                $taxTotal = 0;
                if ($productInput['tax_id']) {
                    $taxTotal = $productInput['tax_percentage'] * $subTotal / 100;
                }
                $grandTotal = $subTotal + $taxTotal;

                $salesProductInput[] = [
                    'sales_id' => $sales->id,
                    'product_id' => $selectProduct->id,
                    'description' => $productInput['description'],
                    'quantity' => $productInput['quantity'],
                    'unit' => $productInput['unit'],
                    'unit_price' => $productInput['unit_price'],
                    'sub_total' => $subTotal,
                    'tax_id' => $productInput['tax_id'] ? $productInput['tax_id'] : null,
                    'tax_percentage' => $productInput['tax_id'] ? $productInput['tax_percentage'] : null,
                    'tax_amount' => $taxTotal,
                    'grand_total' => $grandTotal,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $subTotalFinal = $subTotalFinal + $subTotal;
                $taxTotalFinal = $taxTotalFinal + $taxTotal;

                $isSame = null;
                foreach ($salesJournalData as $key => $sJ) {
                    if ($sJ['account_id'] === $selectProduct->sale_account_id) {
                        $isSame = $key;
                        break;
                    }
                }

                if (!is_null($isSame)) {
                    $salesJournalData[$isSame]['credit'] = $salesJournalData[$isSame]['credit'] + $subTotal;
                } else {
                    $salesJournalData[] = [
                        'sales_id' => $sales->id,
                        'account_id' => $selectProduct->sale_account_id,
                        'debit' => 0,
                        'credit' => $subTotal,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }

                if ($productInput['tax_id']) {
                    $tax = Tax::find($productInput['tax_id']);
                    $isSame = null;
                    foreach ($salesJournalTaxData as $key => $sJ) {
                        if ($sJ['account_id'] === $tax->sell_account_id) {
                            $isSame = $key;
                            break;
                        }
                    }
                    if (!is_null($isSame)) {
                        $salesJournalTaxData[$isSame]['credit'] = $salesJournalTaxData[$isSame]['credit'] + $taxTotal;
                    } else {
                        $salesJournalTaxData[] = [
                            'sales_id' => $sales->id,
                            'account_id' => $tax->sell_account_id,
                            'debit' => 0,
                            'credit' => $taxTotal,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ];
                    }
                }
            }
            $discountAmount = 0;
            if ($data['discount_amount'] > 0) {
                if ($data['discount_type'] == '%') {
                    $discountAmount = $data['discount_amount'] * $subTotalFinal / 100;
                } else {
                    $discountAmount = $data['discount_amount'];
                }
            }
            $sales->sub_total = $subTotalFinal;
            $sales->discount_type = $data['discount_type'];
            $sales->discount_amount = $data['discount_amount'];
            $sales->tax_total_amount = $taxTotalFinal;
            $sales->grand_total = $sales->sub_total - $discountAmount + $sales->tax_total_amount;
            $sales->save();

            $salesJournalData[0]['debit'] = $sales->grand_total;

            $doService = new DigitalOceanService();
            $salesAttachments = [];
            for ($i = 0; $i < 5; $i++) {
                if (isset($data['attachment' . $i])) {
                    $image = $data['attachment' . $i];

                    if (is_object($image)) {
                        $resultImage = $doService->uploadImageToDO($image, 'sales');
                        if (!$resultImage['status']) return $resultImage;
                        $url = $resultImage['data'];
                        $name = $image->getClientOriginalName();
                        $size = filesize($image);
                        $type = $image->getMimeType();
                    } else {
                        $salesAttachment = SalesAttachment::find($image);
                        $url = $salesAttachment->url;
                        $name = $salesAttachment->name;
                        $size = $salesAttachment->size;
                        $type = $salesAttachment->type;
                    }

                    $salesAttachments[] = [
                        'sales_id' => $sales->id,
                        'url' => $url,
                        'name' => $name,
                        'size' => $size,
                        'type' => $type,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }
            }

            if ($data['id']) {
                SalesAttachment::where('sales_id', $sales->id)->delete();
            }

            SalesProduct::insert($salesProductInput);
            SalesJournal::insert(array_merge($salesJournalData, $salesJournalTaxData));
            if (count($salesAttachments) > 0) {
                SalesAttachment::insert($salesAttachments);
            }

            DB::commit();
            return resultFunction($message . " sales is successfully", true, $sales);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $sales = Sales::with(['sales_products.product', 'sales_products.tax', 'sales_attachments', 'customer',
            'sales_journals.coa', 'sales_payments.coa'])->find($id);
            if (!$sales) return resultFunction("Err code SR-D: sales not found");

            return resultFunction("", true, $sales);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function storePayment($request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, [
                'sales_id' => '',
                "deposit_to" => 'required',
                "payment_amount" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SP: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $coa = Coa::find($data['deposit_to']);
            if (!$coa) return resultFunction("Err code SR-SP: customer not found for ID " . $data['deposit_to']);

            $message = "Creating";
            if ($data['id']) {
                $salesPayment = SalesPayment::find($data['id']);
                if (!$salesPayment) return resultFunction("Err code SR-SP: sales not found for ID " . $data['id']);
                $message = 'Updating';

                SalesPaymentAttachment::where('sales_payment_id', $salesPayment->id)->delete();
                SalesPaymentJournal::where('sales_payment_id', $salesPayment->id)->delete();
            } else {
                $salesPayment = new SalesPayment();
                $salesPayment->sales_id = $data['sales_id'];
            }
            $salesPayment->deposit_to = $data['deposit_to'];
            $salesPayment->payment_method = $data['payment_method'];
            $salesPayment->payment_date = $data['payment_date'];
            $salesPayment->due_date = $data['due_date'];
            $salesPayment->payment_amount = $data['payment_amount'];
            $salesPayment->memo = $data['memo'];
            $salesPayment->save();

            $salesPaymentJournals = [];
            $salesPaymentJournals[] = [
                'sales_payment_id' => $salesPayment->id,
                'account_id' => $data['deposit_to'],
                'debit' => $data['payment_amount'],
                'credit' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $salesPaymentJournals[] = [
                'sales_payment_id' => $salesPayment->id,
                'account_id' => 2388,  // sementara account payable
                'debit' => 0,
                'credit' => $data['payment_amount'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $doService = new DigitalOceanService();
            $salesAttachments = [];
            for ($i = 0; $i < 5; $i++) {
                if (isset($data['attachment' . $i])) {
                    $image = $data['attachment' . $i];

                    if (is_object($image)) {
                        $resultImage = $doService->uploadImageToDO($image, 'sales-payment');
                        if (!$resultImage['status']) return $resultImage;
                        $url = $resultImage['data'];
                        $name = $image->getClientOriginalName();
                        $size = filesize($image);
                        $type = $image->getMimeType();
                    } else {
                        $salesAttachment = SalesAttachment::find($image);
                        $url = $salesAttachment->url;
                        $name = $salesAttachment->name;
                        $size = $salesAttachment->size;
                        $type = $salesAttachment->type;
                    }

                    $salesAttachments[] = [
                        'sales_payment_id' => $salesPayment->id,
                        'url' => $url,
                        'name' => $name,
                        'size' => $size,
                        'type' => $type,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }
            }

            if ($data['id']) {
                SalesPaymentAttachment::where('sales_payment_id', $salesPayment->id)->delete();
            }

            SalesPaymentJournal::insert($salesPaymentJournals);
            if (count($salesAttachments) > 0) {
                SalesPaymentAttachment::insert($salesAttachments);
            }

            $this->adjustPaymentAmount($salesPayment->sales_id);

            DB::commit();
            return resultFunction($message . " sales payment is successfully", true, $salesPayment);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SP: catch " . $e->getMessage());
        }
    }

    public function adjustPaymentAmount($salesId) {
        $paymentAmount = SalesPayment::with([])
            ->where('sales_id', $salesId)
            ->sum('payment_amount');

        $sales = Sales::find($salesId);
        $sales->payment_amount_total = $paymentAmount;
        $sales->save();

    }

    public function detailPayment($id) {
        try {
            $salesPayment = SalesPayment::with(['sales.customer', 'coa', 'payment_method', 'sales_payment_attachments', 'sales_payment_journals.coa'])->find($id);
            if (!$salesPayment) return resultFunction("Err code SR-D: sales payment not found");

            return resultFunction("", true, $salesPayment);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function deletePayment($id, $salesId) {
        try {
            $salesPayment = SalesPayment::with(['sales.customer', 'coa', 'payment_method', 'sales_payment_attachments', 'sales_payment_journals.coa'])->find($id);
            if (!$salesPayment) return resultFunction("Err code SR-D: sales payment not found");

            $salesPayment->delete();
            SalesPaymentJournal::where('sales_payment_id', $id)->delete();
            SalesPaymentAttachment::where('sales_payment_id', $id)->delete();

            $this->adjustPaymentAmount($salesId);
            return resultFunction("Delete payment is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function summarizeCount($companyId) {
        try {
            $result = [
                'open_invoice' => [
                    'amount' => 0,
                    'total' => 0
                ],
                'overdue_invoice' => [
                    'amount' => 0,
                    'total' => 0
                ],
                'payment_last_month' => [
                    'amount' => 0,
                    'total' => 0
                ]

            ];

            $dateNow = date("Y-m-d");
            $salesOpenInvoice = Sales::with([])->where('company_id', $companyId)->where('payment_amount_total', 0)->get();
            foreach ($salesOpenInvoice as $item) {
                $result['open_invoice']['amount'] = $result['open_invoice']['amount'] + $item->grand_total;
            }
            $result['open_invoice']['total'] = count($salesOpenInvoice);

            $salesOverdueInvoice = Sales::with([])->where('company_id', $companyId)->where('due_date', '<', $dateNow)->get();
            foreach ($salesOverdueInvoice as $item) {
                $result['overdue_invoice']['amount'] = $result['overdue_invoice']['amount'] + $item->grand_total;
            }
            $result['overdue_invoice']['total'] = count($salesOverdueInvoice);

            $salesPaymentLastMonth = Sales::with([])->where('company_id', $companyId)
                ->where('payment_amount_total', '>', 0)->get();
            foreach ($salesPaymentLastMonth as $item) {
                $result['payment_last_month']['amount'] = $result['payment_last_month']['amount'] + $item->payment_amount_total;
            }
            $result['payment_last_month']['total'] = count($salesPaymentLastMonth);

            return resultFunction("", true, $result);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }
}