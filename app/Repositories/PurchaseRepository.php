<?php

namespace App\Repositories;

use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseRepository {

    public function storeSupplier($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
                "phone" => 'required',
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
            $productUnit->email = $data['email'] ?? null;
            $productUnit->phone = $data['phone'];
            $productUnit->identity_number = $data['identity_number'] ?? "";
            $productUnit->npwp_number = $data['npwp_number'] ?? null;
            $productUnit->address = $data['address'] ?? null;
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

    public function store($data, $companyId) {
        try {
            DB::beginTransaction();

            $validator = \Validator::make($data, [
                "supplier" => 'required',
                "invoice_date" => 'required',
                "due_date" => 'required',
                "products" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-S: " . collect($validator->errors()->all())->implode(" , "));

            $supplier = Supplier::find($data['supplier']);
            if (!$supplier) return resultFunction("Err code PR-S: supplier not found");

            /*$materials = Material::with([])
                ->whereIn('id', array_column((collect($data['products'])->where('type', "Material"))->toArray(), 'id'))
                ->get();*/

            if ($data['id']) {
                $purchaseNew = Purchase::find($data['id']);
                if (!$purchaseNew) return resultFunction("Err code PR-S: purchase not found");
                PurchaseItem::where('purchase_id', $purchaseNew->id)->delete();
            } else {
                $purchaseNew = new Purchase();
                $purchaseNew->bill_number = "DRAFT";
            }
            $purchaseNew->company_id = $companyId;
            $purchaseNew->supplier_id = $supplier->id;
            $purchaseNew->invoice_date = $data['invoice_date'];
            $purchaseNew->due_date = $data['due_date'];
            $purchaseNew->amount_total = 0;
            $purchaseNew->description = $data['description'];
            $purchaseNew->save();

            $items = [];
            $amountTotal = 0;
            foreach ($data['products'] as $prod) {
                $items[] = [
                    "purchase_id" => $purchaseNew->id,
                    "product_id" => $prod['type'] == 'Product' ? $prod['id'] : null,
                    "material_id" => $prod['type'] == 'Material' ? $prod['id'] : null,
                    "quantity" => $prod['quantity'],
                    'price_per_unit' => $prod['amount_per_unit'],
                    "amount_total" => $prod['quantity'] * $prod['amount_per_unit'],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ];
                $amountTotal = $amountTotal + ($prod['quantity'] * $prod['amount_per_unit']);
            }
            $purchaseNew->amount_total = $amountTotal;
            $purchaseNew->save();

            PurchaseItem::insert($items);

            DB::commit();
            return resultFunction("Creating purchase is successfully", true, $purchaseNew);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $purchase = Purchase::with(['purchase_items.product', 'purchase_items.material', 'supplier'])->find($id);
            if (!$purchase) return resultFunction("Err code SR-D: purchase not found");

            return resultFunction("", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function approve($id) {
        try {
            DB::beginTransaction();

            $purchase = Purchase::with(['purchase_items.product', 'purchase_items.material', 'supplier'])->find($id);
            if (!$purchase) return resultFunction("Err code PR-A: purchase not found");

            if ($purchase->bill_number !== 'DRAFT') return resultFunction("Err code PR-A: status is not draft");
            $purchase->bill_number = "Purchase Invoice #" . $purchase->id;

            foreach ($purchase->purchase_items as $item) {
                if ($item->product_id) {

                } else {
                    $material = $item->material;
                    $material->stock = $material->stock + $item->quantity;
                    $material->last_price_per_unit = $item->price_per_unit;
                    $material->save();

                    $materialHistory = new MaterialHistory();
                    $materialHistory->material_id = $material->id;
                    $materialHistory->type_history = 'purchase';
                    $materialHistory->stock = $item->quantity;
                    $materialHistory->note = $purchase->bill_number;
                    $materialHistory->price_per_unit = $item->price_per_unit;
                    $materialHistory->save();
                }
            }
            $purchase->save();
            DB::commit();
            return resultFunction("", true, $purchase);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-A: catch " . $e->getMessage());
        }
    }
}