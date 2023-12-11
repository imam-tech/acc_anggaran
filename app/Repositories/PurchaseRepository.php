<?php

namespace App\Repositories;

use App\Models\Supplier;

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
            $validator = \Validator::make($data, [
                "supplier" => 'required',
                "invoice_date" => 'required',
                "due_date" => 'required',
                "products" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-S: " . collect($validator->errors()->all())->implode(" , "));

            $supplier = Supplier::find($data['supplier']);
            if (!$supplier) return resultFunction("Err code PR-S: supplier not found");

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }
}