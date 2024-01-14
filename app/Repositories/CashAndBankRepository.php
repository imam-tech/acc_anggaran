<?php

namespace App\Repositories;

use App\Models\CashAndBank;
use App\Models\Coa;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CashAndBankRepository {
    public function store($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "account_name" => "required",
                "account_number" => "required",
                "type" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code CAB-S: " . collect($validator->errors()->all())->implode(" , "));
            DB::beginTransaction();

            $company = Company::find($companyId);
            $cashId = $company->type === 'pt' ? 4 : 50;
            $bankId = $company->type === 'pt' ? 5: 51;
            $creditCardId = $company->type === 'pt' ? 25 : 71;

            if ($data['id']) {
                $cashAndBank = CashAndBank::find($data['id']);
                if (!$cashAndBank) return resultFunction("Err code CAB-S: data cashbank not found");

                $coa = Coa::find($cashAndBank->coa_id);
                if (!$coa) return resultFunction("Err code CAB-S: data coa not found");

                $coa->account_code = $data['account_number'] . '-' . $data['account_name'];
                $coa->account_number = $data['account_number'];
                $coa->account_name = $data['account_name'];
                $coa->description = $data['description'] ? $data['description'] : '';
                $coa->save();
            } else {
                $coa = new Coa();
                $coa->company_id = $companyId;
                $coa->category_id = $data['type'] === 'Cash' ? $cashId : ($data['type'] === 'Bank' ? $bankId : $creditCardId);
                $coa->posting_id = 1;
                $coa->is_active = 1;

                $coa->account_code = "";
                $coa->account_number = "";
                $coa->account_name = "";
                $coa->description = "";
                $coa->account_type = in_array($data['type'], ['Cash', 'Bank']) ? 'Debit' : 'Credit';
                $coa->save();

                $cashAndBank = new CashAndBank();
                $cashAndBank->company_id = $companyId;
                $cashAndBank->type = $data['type'];
                $cashAndBank->coa_id = $coa->id;
                $cashAndBank->save();
            }
            $coa->category_id = $data['type'] === 'Cash' ? $cashId : ($data['type'] === 'Bank' ? $bankId : $creditCardId);
            $coa->account_code = $data['account_number'] . '-' . $data['account_name'];
            $coa->account_number = $data['account_number'];
            $coa->account_name = $data['account_name'];
            $coa->description = $data['description'];
            $coa->account_type = in_array($data['type'], ['Cash', 'Bank']) ? 'Debit' : 'Credit';
            $coa->save();

            $cashAndBank->type = $data['type'];
            $cashAndBank->bank_name = $data['bank_name'];
            $cashAndBank->bank_account_number = $data['bank_account_number'];
            $cashAndBank->save();

            DB::commit();
            return resultFunction("Successfully processing account", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CAB-S: catch " . $e->getMessage());
        }
    }

    public function index($companyId)
    {
        $company = Company::find($companyId);
        $cashId = $company->type === 'pt' ? 4 : 50;
        $bankId = $company->type === 'pt' ? 5: 51;
        $creditCardId = $company->type === 'pt' ? 25 : 71;

        $cashBanks = CashAndBank::with(['coa.coaCategory'])
            ->where('company_id', $companyId)
            ->get();

        $cashs = [];
        $banks = [];
        $creditCards = [];
        foreach ($cashBanks as $cashBank) {
            $cashBank->coa->statement_balance = $cashBank->statement_balance;
            $cashBank->coa->balance_in_jurnal = $cashBank->balance_in_jurnal;
            $cashBank->coa->cash_and_bank_id = $cashBank->id;
            if ($cashBank->coa->category_id === $cashId) {
                $cashs[] = $cashBank->coa;
            }

            if ($cashBank->coa->category_id === $bankId) {
                $banks[] = $cashBank->coa;
            }

            if ($cashBank->coa->category_id === $creditCardId) {
                $creditCards[] = $cashBank->coa;
            }
        }


        return [
            "cash_and_bank" => [
                'cash' => $cashs,
                'bank' => $banks
            ],
            "credit_card" => $creditCards,
            "cash_id" => $cashId,
            'bank_id' => $bankId,
            'credit_card_id' => $creditCardId
        ];
    }

    public function detail($id) {
        try {
            $cashBank = CashAndBank::with(['coa'])->find($id);
            if (!$cashBank) return resultFunction("Err code CAB-D: cash and bank not found");

            if (!$cashBank->coa) return resultFunction("Err code CAB-D: coa not found");

            return resultFunction("", true, $cashBank);
        } catch (\Exception $e) {
            return resultFunction("Err code CAB-D: catch " . $e->getMessage());
        }
    }
}