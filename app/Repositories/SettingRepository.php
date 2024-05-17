<?php

namespace App\Repositories;

use App\Models\App;
use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\SettingFlip;
use App\Models\SettingGeneral;
use App\Models\SettingView;
use App\Services\FlipService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $settingFlip->app_id = Auth::user()->app_id;
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

    public function storePm($data) {
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
            if (!$pm) return resultFunction("Err code SR-AP: payment method not found for ID " .$id);

            $pm->is_archive = !$pm->is_archive;
            $pm->save();

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-AP: catch " . $e->getMessage());
        }
    }

    public function storeView($data) {
        try {
            DB::beginTransaction();

            $validator = \Validator::make($data, [
                "id" => "required",
                "setting_view" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SV: " . collect($validator->errors()->all())->implode(" , "));

            $app = App::find($data['id']);
            if (!$app) return resultFunction("Err code SR: company not found");

            $saveParams = [];
            foreach ($data['setting_view'] as $view) {
                $saveParams[] = [
                    "app_id" => $app->id,
                    "label" => $view['label'],
                    "is_show" => $view['is_show'],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ];
            }

            SettingView::where('app_id', $app->id)->delete();
            SettingView::insert($saveParams);

            DB::commit();
            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SV: catch " . $e->getMessage());
        }
    }

    public function setGeneral($data) {
        try {
            $validator = \Validator::make($data, [
                "id" => "required",
                "label" => "required",
                "label_value" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SG: " . collect($validator->errors()->all())->implode(" , "));

            $app = App::find($data['id']);
            if (!$app) return resultFunction("Err code SR: company not found");

            $settingGeneral = SettingGeneral::with([])
                ->where('app_id', $app->id)
                ->where('label', $data['label'])
                ->first();
            if (!$settingGeneral) {
                $settingGeneral = new SettingGeneral();
                $settingGeneral->app_id = $app->id;
                $settingGeneral->label = $data['label'];
            }
            $settingGeneral->label_value = $data['label_value'];
            $settingGeneral->save();

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SG: catch " . $e->getMessage());
        }
    }
}