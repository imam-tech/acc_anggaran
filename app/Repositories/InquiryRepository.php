<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Inquiry;
use App\Services\FlipService;

class InquiryRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "bank" => "required",
                "account_number" => "required",
                "company_id" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code IR-St: " . collect($validator->errors()->all())->implode(" , "));

            $company = Company::with(['settingFlip'])->find($data['company_id']);
            if (!$company) return resultFunction("Err code IR-St: company not found");

            if (!$company->settingFlip) return resultFunction("Err code IR-St: setting flip not found");

            $flipService = new FlipService(decrypt($company->settingFlip->flip_key));

            $payloads = [
                'account_number' => $data['account_number'],
                'bank_code' => $data['bank']
            ];
            $respValid = $flipService->checkInquiry($payloads);

            $inquiry = new Inquiry();
            $inquiry->bank = $data['bank'];
            $inquiry->name = $respValid->account_holder;
            $inquiry->account_number = $respValid->account_number;
            $inquiry->save();

            return resultFunction("Creating Inquiry successfully", true, $inquiry);
        } catch (\Exception $e) {
            return resultFunction("Err code IR-St: catch " . $e->getMessage());
        }
    }
}