<?php

namespace App\Repositories;

use App\Models\Material;

class ManufactureRepository {
    public function storeMaterial($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
                "unit" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code MR-SM: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $material = Material::find($data['id']);
                if (!$material) return resultFunction("Err code MR-SM: material not found");
            } else {
                $material = new Material();
                $material->company_id = $companyId;
                $material->stock = $data['stock'];
            }

            $material->name = $data['name'];
            $material->unit = $data['unit'];
            if ($data['image']) {
                $material->image = $data['image'];
            }
            $material->save();

            return resultFunction("Processing data is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code MR-SM: catch " . $e->getMessage());
        }
    }
}