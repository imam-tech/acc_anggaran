<?php

namespace App\Repositories;

use App\Models\Inquiry;

class InquiryRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "bank" => "required",
                "account_number" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code IR-St: " . collect($validator->errors()->all())->implode(" , "));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'https://old.importir.com/api/check-inquiry/' . $data['account_number'] . '/' . $data['bank'] . '?token=syigdfjhagsjdf766et4wff6');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $valid = json_decode($response, true);
            if (!$valid['status']) return resultFunction("Err code IR-St: " . $valid['message']);

            if ($valid['message']['status'] !== 'SUCCESS')  return resultFunction("Err code IR-St: " . $valid['message']['status']);

            $inquiry = new Inquiry();
            $inquiry->bank = $data['bank'];
            $inquiry->name = $valid['message']['account_holder'];
            $inquiry->account_number = $data['account_number'];
            $inquiry->save();

            return resultFunction("Creating Inquiry successfully", true, $inquiry);
        } catch (\Exception $e) {
            return resultFunction("Err code IR-St: catch " . $e->getMessage());
        }
    }
}