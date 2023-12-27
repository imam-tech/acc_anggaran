<?php

namespace App\Repositories;

use App\Models\Coa;
use App\Models\Contact;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseAttachment;
use App\Models\PurchaseJournal;
use App\Models\PurchasePayment;
use App\Models\PurchasePaymentAttachment;
use App\Models\PurchasePaymentJournal;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Tax;
use App\Services\DigitalOceanService;
use Illuminate\Support\Facades\DB;

class PurchaseRepository {

    public function store($request, $companyId) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, [
                "contact_id" => 'required',
                "transaction_date" => 'required',
                'due_date' => 'required',
                "products" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-S: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $contact = Contact::find($data['contact_id']);
            if (!$contact) return resultFunction("Err code SR-S: supplier not found for ID " . $data['contact_id']);

            $message = "Creating";
            if ($data['id']) {
                $purchase = Purchase::find($data['id']);
                if (!$purchase) return resultFunction("Err code SR-S: sales not found for ID " . $data['id']);
                $message = 'Updating';

                PurchaseProduct::where('purchase_id', $purchase->id)->delete();
                PurchaseJournal::where('purchase_id', $purchase->id)->delete();
            } else {
                $purchase = new Purchase();
                $purchase->company_id = $companyId;
                $purchase->transaction_number = '';
                $purchase->payment_amount_total = 0;
            }
            $purchase->contact_id = $contact->id;
            $purchase->contact_email = $data['contact_email'];
            $purchase->billing_address = $data['billing_address'];
            $purchase->transaction_date = $data['transaction_date'];
            $purchase->due_date = $data['due_date'];
            $purchase->message = $data['message'];
            $purchase->sub_total = 0;
            $purchase->grand_total = 0;
            $purchase->save();
            $purchase->transaction_number = 'Purchase Invoice #' . $purchase->id;
            $data['products'] = json_decode($data['products'], true);

            $products = Product::with([])
                ->whereIn('id', array_column($data['products'], 'id'))
                ->get();

            $purchaseProductInput = [];
            $purchaseJournalData = [];
            $purchaseJournalData[] = [
                'purchase_id' => $purchase->id,
                'account_id' => $contact->purchase_account_id,
                'debit' => 0,
                'credit' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $purchaseJournalTaxData = [];
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

                $purchaseProductInput[] = [
                    'purchase_id' => $purchase->id,
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
                foreach ($purchaseJournalData as $key => $sJ) {
                    if ($sJ['account_id'] === $selectProduct->purchase_account_id) {
                        $isSame = $key;
                        break;
                    }
                }

                if (!is_null($isSame)) {
                    $purchaseJournalData[$isSame]['debit'] = $purchaseJournalData[$isSame]['credit'] + $subTotal;
                } else {
                    $purchaseJournalData[] = [
                        'purchase_id' => $purchase->id,
                        'account_id' => $selectProduct->purchase_account_id,
                        'debit' => $subTotal,
                        'credit' => 0,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }

                if ($productInput['tax_id']) {
                    $tax = Tax::find($productInput['tax_id']);
                    $isSame = null;
                    foreach ($purchaseJournalTaxData as $key => $sJ) {
                        if ($sJ['account_id'] === $tax->buy_account_id) {
                            $isSame = $key;
                            break;
                        }
                    }
                    if (!is_null($isSame)) {
                        $purchaseJournalTaxData[$isSame]['credit'] = $purchaseJournalTaxData[$isSame]['credit'] + $taxTotal;
                    } else {
                        $purchaseJournalTaxData[] = [
                            'purchase_id' => $purchase->id,
                            'account_id' => $tax->buy_account_id,
                            'debit' => $taxTotal,
                            'credit' => 0,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ];
                    }
                }
            }
            $purchase->sub_total = $subTotalFinal;
            $purchase->tax_total_amount = $taxTotalFinal;
            $purchase->grand_total = $purchase->sub_total + $purchase->tax_total_amount;
            $purchase->save();

            $purchaseJournalData[0]['credit'] = $purchase->grand_total;

            $doService = new DigitalOceanService();
            $purchaseAttachments = [];
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
                        $purchaseAttachment = PurchaseAttachment::find($image);
                        $url = $purchaseAttachment->url;
                        $name = $purchaseAttachment->name;
                        $size = $purchaseAttachment->size;
                        $type = $purchaseAttachment->type;
                    }

                    $purchaseAttachments[] = [
                        'purchase_id' => $purchase->id,
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
                PurchaseAttachment::where('purchase_id', $purchase->id)->delete();
            }

            PurchaseProduct::insert($purchaseProductInput);
            PurchaseJournal::insert(array_merge($purchaseJournalData, $purchaseJournalTaxData));
            if (count($purchaseAttachments) > 0) {
                PurchaseAttachment::insert($purchaseAttachments);
            }

            DB::commit();
            return resultFunction($message . " purchase is successfully", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $purchase = Purchase::with(['purchase_products.product', 'purchase_products.tax', 'purchase_attachments', 'contact',
                'purchase_journals.coa', 'purchase_payments.coa'])->find($id);
            if (!$purchase) return resultFunction("Err code SR-D: purchase not found");

            return resultFunction("", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $purchase = Purchase::with(['purchase_payments'])->find($id);
            if (!$purchase) return resultFunction("Err code SR-D: purchase not found");

            if (count($purchase->purchase_payments) > 0) return resultFunction("Err code SR-D: purchase is already has payment");

            $purchase->delete();
            return resultFunction("", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function storePayment($request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, [
                'purchase_id' => '',
                "pay_from" => 'required',
                "payment_amount" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SP: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $coa = Coa::find($data['pay_from']);
            if (!$coa) return resultFunction("Err code SR-SP: coa not found for ID " . $data['pay_from']);

            $message = "Creating";
            if ($data['id']) {
                $purchasePayment = PurchasePayment::find($data['id']);
                if (!$purchasePayment) return resultFunction("Err code SR-SP: purchase not found for ID " . $data['id']);
                $message = 'Updating';

                PurchasePaymentAttachment::where('purchase_payment_id', $purchasePayment->id)->delete();
                PurchasePaymentJournal::where('purchase_payment_id', $purchasePayment->id)->delete();
            } else {
                $purchasePayment = new PurchasePayment();
                $purchasePayment->purchase_id = $data['purchase_id'];
            }

            $purchase = Purchase::find($purchasePayment->purchase_id);
            if (!$purchase) return resultFunction("Err code SR-SP: purchase not found for ID " . $purchasePayment->purchase_id);

            $contact = Contact::find($purchase->contact_id);

            $purchasePayment->pay_from = $data['pay_from'];
            $purchasePayment->payment_method = $data['payment_method'];
            $purchasePayment->payment_date = $data['payment_date'];
            $purchasePayment->due_date = $data['due_date'];
            $purchasePayment->payment_amount = $data['payment_amount'];
            $purchasePayment->memo = $data['memo'];
            $purchasePayment->save();

            $purchasePaymentJournals = [];
            $purchasePaymentJournals[] = [
                'purchase_payment_id' => $purchasePayment->id,
                'account_id' => $contact->purchase_account_id,
                'debit' => $data['payment_amount'],
                'credit' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $purchasePaymentJournals[] = [
                'purchase_payment_id' => $purchasePayment->id,
                'account_id' => $data['pay_from'],
                'debit' => 0,
                'credit' => $data['payment_amount'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $doService = new DigitalOceanService();
            $purchaseAttachments = [];
            for ($i = 0; $i < 5; $i++) {
                if (isset($data['attachment' . $i])) {
                    $image = $data['attachment' . $i];

                    if (is_object($image)) {
                        $resultImage = $doService->uploadImageToDO($image, 'purchase-payment');
                        if (!$resultImage['status']) return $resultImage;
                        $url = $resultImage['data'];
                        $name = $image->getClientOriginalName();
                        $size = filesize($image);
                        $type = $image->getMimeType();
                    } else {
                        $purchaseAttachment = PurchaseAttachment::find($image);
                        $url = $purchaseAttachment->url;
                        $name = $purchaseAttachment->name;
                        $size = $purchaseAttachment->size;
                        $type = $purchaseAttachment->type;
                    }

                    $purchaseAttachments[] = [
                        'purchase_payment_id' => $purchasePayment->id,
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
                PurchasePaymentAttachment::where('purchase_payment_id', $purchasePayment->id)->delete();
            }

            PurchasePaymentJournal::insert($purchasePaymentJournals);
            if (count($purchaseAttachments) > 0) {
                PurchasePaymentAttachment::insert($purchaseAttachments);
            }

            DB::commit();
            return resultFunction($message . " purchase payment is successfully", true, $purchasePayment);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SP: catch " . $e->getMessage());
        }
    }

    public function adjustPaymentAmount($purchaseId) {
        $paymentAmount = PurchasePayment::with([])
            ->where('purchase_id', $purchaseId)
            ->whereNotNull('status')
            ->sum('payment_amount');

        $purchase = Purchase::find($purchaseId);
        $purchase->payment_amount_total = $paymentAmount;
        $purchase->save();

    }

    public function detailPayment($id) {
        try {
            $purchasePayment = PurchasePayment::with(['purchase.contact', 'coa', 'payment_method', 'purchase_payment_attachments', 'purchase_payment_journals.coa'])->find($id);
            if (!$purchasePayment) return resultFunction("Err code SR-D: purchase payment not found");

            return resultFunction("", true, $purchasePayment);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function approvePayment($id) {
        try {
            $purchasePayment = PurchasePayment::with([])->find($id);
            if (!$purchasePayment) return resultFunction("Err code SR-D: purchase payment not found");

            $purchasePayment->status = 'approved';
            $purchasePayment->save();
            $this->adjustPaymentAmount($purchasePayment->purchase_id);

            return resultFunction("", true, $purchasePayment);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function deletePayment($id, $purchaseId) {
        try {
            $purchasePayment = PurchasePayment::with(['purchase_payment_attachments', 'purchase_payment_journals'])->find($id);
            if (!$purchasePayment) return resultFunction("Err code SR-D: purchase payment not found");

            $purchasePayment->delete();
            PurchasePaymentJournal::where('purchase_payment_id', $id)->delete();
            PurchasePaymentAttachment::where('purchase_payment_id', $id)->delete();

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
            $purchaseOpenInvoice = Purchase::with([])->where('company_id', $companyId)->where('payment_amount_total', 0)->get();
            foreach ($purchaseOpenInvoice as $item) {
                $result['open_invoice']['amount'] = $result['open_invoice']['amount'] + $item->grand_total;
            }
            $result['open_invoice']['total'] = count($purchaseOpenInvoice);

            $purchaseOverdueInvoice = Purchase::with([])->where('company_id', $companyId)
                ->whereRaw('payment_amount_total <> grand_total')
                ->where('due_date', '<', $dateNow)->get();
            foreach ($purchaseOverdueInvoice as $item) {
                $result['overdue_invoice']['amount'] = $result['overdue_invoice']['amount'] + $item->grand_total;
            }
            $result['overdue_invoice']['total'] = count($purchaseOverdueInvoice);

            $purchasePaymentLastMonth = Purchase::with([])->where('company_id', $companyId)
                ->where('payment_amount_total', '>', 0)->get();
            foreach ($purchasePaymentLastMonth as $item) {
                $result['payment_last_month']['amount'] = $result['payment_last_month']['amount'] + $item->payment_amount_total;
            }
            $result['payment_last_month']['total'] = count($purchasePaymentLastMonth);

            return resultFunction("", true, $result);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }
}