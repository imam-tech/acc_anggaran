<?php

namespace App\Repositories;

use App\Models\CashAndBank;
use App\Models\Coa;
use App\Models\Company;
use App\Models\CompanyAdmin;
use App\Models\PaymentMethod;
use App\Models\ProductUnit;
use App\Models\SettingFlip;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\TransactionFlip;
use App\Models\TransactionStatus;
use App\Services\FlipService;
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

                $coaReceivable = new Coa();
                $coaReceivable->company_id = $company->id;
                $coaReceivable->category_id = $company->type === 'pt' ? 4 : 50;
                $coaReceivable->posting_id = 1;
                $coaReceivable->account_code = "100001-Account Receivable";
                $coaReceivable->account_number = 100001;
                $coaReceivable->account_name = "Account Receivable";
                $coaReceivable->account_type = 'debit';
                $coaReceivable->is_active = 1;
                $coaReceivable->save();

                $cashAndBank = new CashAndBank();
                $cashAndBank->company_id = $company->id;
                $cashAndBank->type = 'Cash';
                $cashAndBank->coa_id = $coaReceivable->id;
                $cashAndBank->statement_balance = 0;
                $cashAndBank->balance_in_jurnal = 0;
                $cashAndBank->save();

                $coaTradePayable = new Coa();
                $coaTradePayable->company_id = $company->id;
                $coaTradePayable->category_id = $company->type === 'pt' ? 23 : 69;
                $coaTradePayable->posting_id = 1;
                $coaTradePayable->account_code = "200001-Trade Payable";
                $coaTradePayable->account_number = 200001;
                $coaTradePayable->account_name = "Trade Payable";
                $coaTradePayable->account_type = 'credit';
                $coaTradePayable->is_active = 1;
                $coaTradePayable->save();

                // Default for product
                $coaSales = new Coa();
                $coaSales->company_id = $company->id;
                $coaSales->category_id = $company->type === 'pt' ? 34 : 80;
                $coaSales->posting_id = 1;
                $coaSales->account_code = "500001-Beban Pokok Pendapatan";
                $coaSales->account_number = 500001;
                $coaSales->account_name = "Beban Pokok Pendapatan";
                $coaSales->account_type = 'debit';
                $coaSales->is_active = 1;
                $coaSales->save();

                // Default for product
                $coaPurchase = new Coa();
                $coaPurchase->company_id = $company->id;
                $coaPurchase->category_id = $company->type === 'pt' ? 32 : 78;
                $coaPurchase->posting_id = 6;
                $coaPurchase->account_code = "400001-Pendapatan";
                $coaPurchase->account_number = 400001;
                $coaPurchase->account_name = "Pendapatan";
                $coaPurchase->account_type = 'credit';
                $coaPurchase->is_active = 1;
                $coaPurchase->save();

                // Default for tax
                $coaSalesTax = new Coa();
                $coaSalesTax->company_id = $company->id;
                $coaSalesTax->category_id = $company->type === 'pt' ? 22 : 68;
                $coaSalesTax->posting_id = 1;
                $coaSalesTax->account_code = "211101-VAT Out";
                $coaSalesTax->account_number = 211101;
                $coaSalesTax->account_name = "VAT Out";
                $coaSalesTax->account_type = 'credit';
                $coaSalesTax->is_active = 1;
                $coaSalesTax->save();

                // Default for tax
                $coaPurchaseTax = new Coa();
                $coaPurchaseTax->company_id = $company->id;
                $coaPurchaseTax->category_id = $company->type === 'pt' ? 12 : 58;
                $coaPurchaseTax->posting_id = 1;
                $coaPurchaseTax->account_code = "114001-VAT In";
                $coaPurchaseTax->account_number = 114001;
                $coaPurchaseTax->account_name = "VAT In";
                $coaPurchaseTax->account_type = 'debit';
                $coaPurchaseTax->is_active = 1;
                $coaPurchaseTax->save();

                Tax::insert([
                    [
                        'company_id' => $company->id,
                        'title' => 'PPN',
                        'type' => 'ppn',
                        'amount' => 10,
                        'sell_account_id' => $coaSalesTax->id,
                        'buy_account_id' => $coaPurchaseTax->id,
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'title' => 'PPH',
                        'type' => 'pph',
                        'amount' => 10,
                        'sell_account_id' => $coaSalesTax->id,
                        'buy_account_id' => $coaPurchaseTax->id,
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'title' => 'No PPN',
                        'type' => 'ppn',
                        'amount' => 0,
                        'sell_account_id' => $coaSalesTax->id,
                        'buy_account_id' => $coaPurchaseTax->id,
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'title' => 'No PPH',
                        'type' => 'pph',
                        'amount' => 0,
                        'sell_account_id' => $coaSalesTax->id,
                        'buy_account_id' => $coaPurchaseTax->id,
                        'is_archive' => 0
                    ]
                ]);

                ProductUnit::insert([
                    [
                        'company_id' => $company->id,
                        'name' => 'Buah',
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'name' => 'Unit',
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'name' => 'Liter',
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'name' => 'Kilogram',
                        'is_archive' => 0
                    ]
                ]);

                PaymentMethod::insert([
                    [
                        'company_id' => $company->id,
                        'name' => 'Cash',
                        'is_archive' => 0
                    ],
                    [
                        'company_id' => $company->id,
                        'name' => 'Transfer Bank',
                        'is_archive' => 0
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
            $company = Company::with(['projects', 'companyAdmins.user', 'settingFlip'])->find($id);
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
            $company = Company::with(['settingFlip'])->find($id);
            if (!$company) return resultFunction("Err code CR-PP: company not found for ID " .$id);

            $transactions = Transaction::with(['transactionItems.transactionItemCoas'])->whereIn('id', $transactionIds)->get();

            if (count($transactions) !== count($transactionIds)) return resultFunction("Err code CR-PP: the transaction data is not match");

            if (!$company->settingFlip) return resultFunction("Err code CR-PP: the flip setting is not set");

            $flipService = new FlipService(decrypt($company->settingFlip->flip_key));
            foreach ($transactions as $transaction) {
                if ($transaction->method  === 'flip') {
                    $result = $flipService->pushToFlip($transaction);
                    if (!$result['status']) return $result;

                    $transaction->current_status = 'processed';
                    $transaction->save();

                    $transactionStatus = new TransactionStatus();
                    $transactionStatus->transaction_id = $transaction->id;
                    $transactionStatus->title = 'processed';
                    $transactionStatus->save();

                    $transactionFlip = new TransactionFlip();
                    $transactionFlip->transaction_id = $transaction->id;
                    $transactionFlip->flip_id = $result['data']->id;
                    $transactionFlip->status = 'requested';
                    $transactionFlip->fee = $result['data']->fee;
                    $transactionFlip->save();
                } else {
                    $transactionRepo = new TransactionRepository();
                    $transactionRepo->pushToJurnal($transaction);
                    $transaction->current_status = 'completed';
                    $transaction->save();

                    $transactionStatus = new TransactionStatus();
                    $transactionStatus->transaction_id = $transaction->id;
                    $transactionStatus->title = 'completed';
                    $transactionStatus->save();
                }
            }

            return resultFunction("Push transaction successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-PP: catch " . $e->getMessage());
        }
    }

    public function callbackFlip($id, $transactionIds) {
        try {
            DB::beginTransaction();
            $company = Company::find($id);
            if (!$company) return resultFunction("Err code CR-CF: company not found for ID " .$id);

            $transactions = Transaction::with(['transactionItems.transactionItemCoas'])->whereIn('id', $transactionIds)->get();

            if (count($transactions) !== count($transactionIds)) return resultFunction("Err code CR-CF: the transaction data is not match");

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
            return resultFunction("Err code CR-CF: catch " . $e->getMessage());
        }
    }

    public function changeSettingFlip($id, $settingFlipId) {
        try {
            $company = Company::find($id);
            if (!$company) return resultFunction("Err code CR-CSF: company not found for ID " .$id);


            $settingFlip = SettingFlip::find($settingFlipId);
            if (!$settingFlip) return resultFunction("Err code CR-CSF: flip not found for ID " .$settingFlipId);

            $company->setting_flip_id = $settingFlip->id;
            $company->save();

            return resultFunction("Setting flip successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-CSF: catch " . $e->getMessage());
        }
    }
}