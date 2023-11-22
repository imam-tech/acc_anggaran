<?php

namespace App\Repositories;

use App\Models\SettingFlip;
use App\Services\FlipService;

class SettingRepository {
    public function storeFlip($data) {
        try {
            $validator = \Validator::make($data, [
                "flip_name" => "required",
                "is_active" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code TR-St: " . collect($validator->errors()->all())->implode(" , "));


            if ($data['id']) {
                $settingFlip = SettingFlip::find($data['id']);
                if (!$settingFlip) return resultFunction("Err code TR-St: setting flip not found for ID " . $data['id']);
                if ($data['flip_key']) {
                    $settingFlip->flip_key = encrypt($data['flip_key']);
                }
                $flipKey = decrypt($settingFlip->flip_key);
            } else {
                $settingFlip = new SettingFlip();
                $settingFlip->flip_key = encrypt($data['flip_key']);
                $flipKey = $data['flip_key'];
            }

            $payloads = [
                'account_number' => "999asdas",
                'bank_code' => "bca"
            ];
            $flipService =  new FlipService($flipKey);
            $respValid = $flipService->checkInquiry($payloads);
            if (!$respValid['status']) return $respValid;

            $settingFlip->flip_name = $data['flip_name'];
            $settingFlip->is_active = $data['is_active'];
            $settingFlip->save();

            $message = $data['id'] ? "Updating SettingFlip successfully" : "Creating SettingFlip successfully";
            return resultFunction($message, true, $settingFlip);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-St: catch " . $e->getMessage());
        }
    }

    public function deleteFlip($id) {
        try {
            $settingFlip = SettingFlip::find($id);
            if (!$settingFlip) return resultFunction("Err code PR-Dl: tax not found for ID " .$id);

            $settingFlip->delete();

            return resultFunction("Deleting SettingFlip successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }
}