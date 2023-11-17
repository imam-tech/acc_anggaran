<?php

namespace App\Repositories;

use App\Models\Tax;

class TaxRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
                "type" => "required",
                "amount" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code TR-St: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $tax = Tax::find($data['id']);
                if (!$tax) return resultFunction("Err code TR-St: company not found for ID " . $data['id']);
            } else {
                $tax = new Tax();
            }
            $tax->title = $data['title'];
            $tax->type = $data['type'];
            $tax->amount = $data['amount'];
            $tax->save();

            $message = $data['id'] ? "Updating Tax successfully" : "Creating Tax successfully";
            return resultFunction($message, true, $tax);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-St: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $tax = Tax::find($id);
            if (!$tax) return resultFunction("Err code PR-Dl: tax not found for ID " .$id);

            $tax->delete();

            return resultFunction("Deleting Tax successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $tax = Tax::with([])->find($id);
            if (!$tax) return resultFunction("Err code CR-Dl: tax not found for ID " .$id);
            return resultFunction("", true, $tax);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-Dl: catch " . $e->getMessage());
        }
    }
}