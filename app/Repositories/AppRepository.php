<?php

namespace App\Repositories;

use App\Models\App;

class AppRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "is_whitelist" => "required",
                "is_multiple_company" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code AR-S: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $app = App::find($data['id']);
                if (!$app) return resultFunction("Err code AR-S: company not found for ID " . $data['id']);
            } else {
                $app = new App();
            }
            $app->is_whitelist = $data['is_whitelist'];
            $app->is_multiple_company = $data['is_multiple_company'];
            $app->domain = $data['domain'];
            $app->save();

            $message = $data['id'] ? "Updating Company successfully" : "Creating Company successfully";
            return resultFunction($message, true, $app);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $app = App::with(['users', 'setting_views', 'max_company'])->find($id);
            if (!$app) return resultFunction("Err code AR-D: app not found for ID " .$id);
            return resultFunction("", true, $app);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-D: catch " . $e->getMessage());
        }
    }
}