<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use App\Models\ProductUnit;
use App\Models\Tag;

class MasterDataRepository {

    public function storePm($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code TR-St: " . collect($validator->errors()->all())->implode(" , "));


            if ($data['id']) {
                $pm = PaymentMethod::find($data['id']);
                if (!$pm) return resultFunction("Err code TR-St: payment method not found for ID " . $data['id']);
            } else {
                $pm = new PaymentMethod();
                $pm->company_id = $companyId;
            }

            $pm->name = $data['name'];
            $pm->save();

            $message = $data['id'] ? "Updating Payment Method successfully" : "Creating Payment Method successfully";
            return resultFunction($message, true, $pm);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-St: catch " . $e->getMessage());
        }
    }

    public function deletePm($id) {
        try {
            $pm = PaymentMethod::find($id);
            if (!$pm) return resultFunction("Err code PR-Dl: payment method not found for ID " .$id);

            $pm->delete();

            return resultFunction("Deleting Payment Method successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }

    public function archivePm($id) {
        try {
            $pm = PaymentMethod::find($id);
            if (!$pm) return resultFunction("Err code PR-Dl: payment method not found for ID " .$id);

            $pm->is_archive = !$pm->is_archive;
            $pm->save();

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }

    public function storeUnit($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productUnit = ProductUnit::find($data['id']);
                if (!$productUnit) return resultFunction("Err code PR-SU: unit not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productUnit = new ProductUnit();
                $productUnit->company_id = $companyId;
            }
            $productUnit->name = $data['name'];
            $productUnit->save();

            return resultFunction($message . " unit is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
        }
    }

    public function deleteUnit($id) {
        try {
            $productUnit = ProductUnit::find($id);
            if (!$productUnit) return resultFunction("Err code PR-DU: unit not found");

            $productUnit->delete();

            return resultFunction("Deleting unit successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function archiveUnit($id) {
        try {
            $productUnit = ProductUnit::find($id);
            if (!$productUnit) return resultFunction("Err code PR-DU: unit not found");

            $productUnit->is_archive = !$productUnit->is_archive;
            $productUnit->save();

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function storeTag($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SU: " . collect($validator->errors()->all())->implode(" , "));


            $message = "Creating";
            if ($data['id']) {
                $productTag = Tag::find($data['id']);
                if (!$productTag) return resultFunction("Err code PR-SU: tag not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $productTag = new Tag();
                $productTag->company_id = $companyId;
            }
            $productTag->name = $data['name'];
            $productTag->save();

            return resultFunction($message . " tag is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SU: catch " . $e->getMessage());
        }
    }

    public function deleteTag($id) {
        try {
            $productTag = Tag::find($id);
            if (!$productTag) return resultFunction("Err code PR-DU: tag not found");

            $productTag->delete();

            return resultFunction("Deleting tag successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }

    public function archiveTag($id) {
        try {
            $productTag = Tag::find($id);
            if (!$productTag) return resultFunction("Err code PR-DU: tag not found");

            $productTag->is_archive = !$productTag->is_archive;
            $productTag->save();

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-DU: catch " . $e->getMessage());
        }
    }
}