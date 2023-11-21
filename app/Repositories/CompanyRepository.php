<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\CompanyAdmin;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\DB;

class CompanyRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
                "type" => "required",
                "voucherPrefix" => "required",
            ]);
            DB::beginTransaction();

            if ($validator->fails()) return resultFunction("Err code CR-St: " . collect($validator->errors()->all())->implode(" , "));

            if ($data['id']) {
                $company = Company::find($data['id']);
                if (!$company) return resultFunction("Err code CR-St: company not found for ID " . $data['id']);
            } else {
                $company = new Company();
            }
            $company->title = $data['title'];
            $company->type = $data['type'];
            $company->voucher_prefix = $data['voucherPrefix'];
            $company->save();

            if (!$data['id']) {
                $now = date("Y-m-d H:i:s");
                CompanyAdmin::insert([
                    [
                        "company_id" => $company->id,
                        "user_id" => null,
                        "name" => "finance_manager",
                        "title" => "Finance Manager",
                        "created_at" => $now,
                        "updated_at" => $now
                    ],
                    [
                        "company_id" => $company->id,
                        "user_id" => null,
                        "name" => "finance_staf",
                        "title" => "Finance Staf",
                        "created_at" => $now,
                        "updated_at" => $now
                    ],
                    [
                        "company_id" => $company->id,
                        "user_id" => null,
                        "name" => "tax_admin",
                        "title" => "Tax Admin",
                        "created_at" => $now,
                        "updated_at" => $now
                    ],
                    [
                        "company_id" => $company->id,
                        "user_id" => null,
                        "name" => "accounting_admin",
                        "title" => "Accounting Admin",
                        "created_at" => $now,
                        "updated_at" => $now
                    ]
                ]);
            }

            $message = $data['id'] ? "Updating Company successfully" : "Creating Company successfully";
            DB::commit();
            return resultFunction($message, true, $company);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-St: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $company = Company::find($id);
            if (!$company) return resultFunction("Err code CR-Dl: company not found for ID " .$id);

            $company->delete();

            return resultFunction("Deleting Company successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-Dl: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $company = Company::with(['projects', 'companyAdmins.user'])->find($id);
            if (!$company) return resultFunction("Err code CR-Dl: company not found for ID " .$id);
            return resultFunction("", true, $company);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-Dl: catch " . $e->getMessage());
        }
    }

    public function adminApproval($data) {
        try {
            $validator = \Validator::make($data, [
                "company_id" => "required",
                "admins" => "required"
            ]);
            DB::beginTransaction();

            if ($validator->fails()) return resultFunction("Err code CR-AA: " . collect($validator->errors()->all())->implode(" , "));

            $company = Company::find($data['company_id']);
            if (!$company) return resultFunction("Err code CR-AA: company not found for ID " . $data['company_id']);

            $companyAdmins = CompanyAdmin::where('company_id', $company->id)
                ->get();

            foreach ($companyAdmins as $companyAdmin) {
                $companyAdmin->user_id = $data['admins'][$companyAdmin->name];
                $companyAdmin->save();
            }

            DB::commit();
            return resultFunction("Setting admin approval successfully", true, $company);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-AA: catch " . $e->getMessage());
        }
    }

    public function pushPlugin($id, $transactionIds) {
        try {
            DB::beginTransaction();
            $company = Company::find($id);
            if (!$company) return resultFunction("Err code CR-PP: company not found for ID " .$id);

            $transactions = Transaction::with(['transactionItems.transactionItemCoas'])->whereIn('id', $transactionIds)->get();

            if (count($transactions) !== count($transactionIds)) return resultFunction("Err code CR-PP: the transaction data is not match");

            $transactionRepo = new TransactionRepository();
            foreach ($transactions as $transaction) {
                $transactionRepo->pushToJurnal($transaction);
                $transaction->current_status = 'completed';
                $transaction->save();

                $transactionStatus = new TransactionStatus();
                $transactionStatus->transaction_id = $transaction->id;
                $transactionStatus->title = 'completed';
                $transactionStatus->save();
            }


            DB::commit();
            return resultFunction("Push transaction successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-PP: catch " . $e->getMessage());
        }
    }
}