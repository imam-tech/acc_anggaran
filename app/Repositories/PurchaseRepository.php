<?php

namespace App\Repositories;

use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseAttachment;
use App\Models\PurchaseJournal;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Tax;
use App\Services\DigitalOceanService;
use Illuminate\Support\Facades\DB;

class PurchaseRepository {

    public function storeSupplier($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SC: " . collect($validator->errors()->all())->implode(" , "));

            $message = "Creating";
            if ($data['id']) {
                $productUnit = Supplier::find($data['id']);
                if (!$productUnit) return resultFunction("Err code SR-SC: supplier not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productUnit = new Supplier();
                $productUnit->company_id = $companyId;
            }
            $productUnit->name = $data['name'];
            $productUnit->email = $data['email'];
            $productUnit->phone = $data['phone'];
            $productUnit->identity_number = $data['identity_number'];
            $productUnit->npwp_number = $data['npwp_number'];
            $productUnit->address = $data['address'];
            $productUnit->save();

            return resultFunction($message . " supplier is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SC: catch " . $e->getMessage());
        }
    }

    public function detailSupplier($id) {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) return resultFunction("Err code SR-DU: supplier not found");

            return resultFunction("", true, $supplier);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-DU: catch " . $e->getMessage());
        }
    }

    public function store($request, $companyId) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, [
                "supplier_id" => 'required',
                "transaction_date" => 'required',
                'due_date' => 'required',
                "products" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-S: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $supplier = Supplier::find($data['supplier_id']);
            if (!$supplier) return resultFunction("Err code SR-S: supplier not found for ID " . $data['supplier_id']);

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
            }
            $purchase->supplier_id = $supplier->id;
            $purchase->supplier_email = $data['supplier_email'];
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
                'account_id' => 2388,  // sementara account payable
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
                    $purchaseJournalData[$isSame]['credit'] = $purchaseJournalData[$isSame]['credit'] + $subTotal;
                } else {
                    $purchaseJournalData[] = [
                        'purchase_id' => $purchase->id,
                        'account_id' => $selectProduct->purchase_account_id,
                        'debit' => 0,
                        'credit' => $subTotal,
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
                            'debit' => 0,
                            'credit' => $taxTotal,
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

            $purchaseJournalData[0]['debit'] = $purchase->grand_total;

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
            $purchase = Purchase::with(['purchase_products.product', 'purchase_products.tax', 'purchase_attachments', 'supplier',
                'purchase_journals.coa'])->find($id);
            if (!$purchase) return resultFunction("Err code SR-D: purchase not found");

            return resultFunction("", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }
}