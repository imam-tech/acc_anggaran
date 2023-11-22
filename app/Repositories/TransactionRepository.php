<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Inquiry;
use App\Models\Journal;
use App\Models\JournalItem;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\TransactionApproval;
use App\Models\TransactionItem;
use App\Models\TransactionItemCoa;
use App\Models\TransactionStatus;
use App\Services\DigitalOceanService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "title" => "required",
                "project_id" => "required",
                "inquiry_id" => "required",
                "items" => "required",
            ]);
            DB::beginTransaction();

            if ($validator->fails()) return resultFunction("Err code TR-St: " . collect($validator->errors()->all())->implode(" , "));

            $project = Project::with(['company.companyAdmins'])->find($data['project_id']);
            if (!$project) return resultFunction("Err code TR-St: product not found for ID " . $data['project_id']);

            if (!$project->company) return resultFunction("Err code TR-St: company not found for ID " . $project->company_id);

            $adminApprovals = array_column($project->company->companyAdmins->toArray(), 'user_id');
            if (in_array(null, $adminApprovals)) return resultFunction("Err code TR-St: the admin approvals are not set correctly");

            $inquiry = Inquiry::find($data['inquiry_id']);
            if (!$inquiry) return resultFunction("Err code TR-St: Inquiry not found for ID " . $data['inquiry_id']);

            $transaction = new Transaction();
            $transaction->company_id = $project->company_id;
            $transaction->project_id = $project->id;
            $transaction->created_by = auth()->user()->id;
            $transaction->transaction_number = "";
            $transaction->title = $data['title'];
            $transaction->description = $data['description'] ?? "";
            $transaction->bank = $inquiry->bank;
            $transaction->account_holder = $inquiry->name;
            $transaction->account_number = $inquiry->account_number;
            $transaction->current_status = 'requested';
            $transaction->save();

            $transactionApprovalData = [];
            foreach ($project->company->companyAdmins as $adminApproval) {
                $transactionApprovalData[] = [
                    'user_id' => $adminApproval->user_id,
                    'transaction_id' => $transaction->id,
                    'title' => $adminApproval->title,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
            }

            $itemSave = [];
            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $itemSave[] = [
                    'transaction_id' => $transaction->id,
                    'title' => $item['title'],
                    'note' => $item['note'] ? $item['note'] : null,
                    'attachment' => $item['attachment'],
                    'input_amount' => $item['amount'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $totalAmount = $totalAmount + $item['amount'];
            }
            $transaction->transaction_number = $project->company->voucher_prefix . $transaction->id;
            $transaction->total_amount = $totalAmount;
            $transaction->save();

            TransactionItem::insert($itemSave);

            TransactionApproval::insert($transactionApprovalData);

            TransactionStatus::create([
                'transaction_id' => $transaction->id,
                'title' => 'requested'
            ]);

            DB::commit();
            return resultFunction("Creating transaction successfully", true, $transaction);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-St: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $transaction = Transaction::with(['transactionItems.transactionItemCoas', 'userCreatedBy', 'transactionStatuses', 'project', 'company',
                'transactionApprovals.user'])
                ->find($id);
            if (!$transaction) return resultFunction("Err code CR-Dl: transaction not found for ID " .$id);
            return resultFunction("", true, $transaction);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-Dl: catch " . $e->getMessage());
        }
    }

    public function approval($id, $status, $itemId) {
        try {
            DB::beginTransaction();
            $transaction = Transaction::with(['transactionApprovals', 'transactionItems.transactionItemCoas'])->find($id);
            if (!$transaction) return resultFunction("Err code TR-Ap: transaction not found for ID " . $id);

            $transactionApproval = $transaction->transactionApprovals->where('user_id', auth()->user()->id)->where('id', $itemId)->first();
            if (!$transactionApproval) return resultFunction("Err code TR-Ap: you don't have an access doing this action");

            if ($transactionApproval->approved_at OR $transactionApproval->rejected_at)  return resultFunction("Err code TR-Ap: the transaction is already processing");

            if (!in_array($status, ['approved', 'rejected']))  return resultFunction("Err code TR-Ap: status must  be approved or rejected only");

            if ($transactionApproval->title === 'Tax Admin') {
                $isPass = true;
                foreach ($transaction->transactionItems as $item) {
                    if (!$item->tax_type) {
                        $isPass = false;
                        break;
                    }
                }
                if (!$isPass) return resultFunction("Err code TR-Ap: you must set all tax");
            }

            if ($transactionApproval->title === 'Accounting Admin') {
                $isPass = true;
                foreach ($transaction->transactionItems as $item) {
                    if (count($item->transactionItemCoas) === 0) {
                        $isPass = false;
                        break;
                    }
                }
                if (!$isPass) return resultFunction("Err code TR-Ap: you must set all coa");
            }

            if ($transactionApproval->title === 'Finance Staf') {
                if (!$transaction->method) return resultFunction("Err code TR-Ap: you must set method flip or manual");
            }

            $statusChange = "";
            if ($status === 'approved') {
                $transactionApproval->approved_at = date("Y-m-d H:i:s");
            } else {
                $transactionApproval->rejected_at = date("Y-m-d H:i:s");
                $transactionApproval->note = null;
                $statusChange = 'rejected';
                $transaction->current_status = $statusChange;
            }

            $transactionApproval->save();

            $transactionApprovalApproved = TransactionApproval::where('transaction_id', $transaction->id)->whereNotNull('approved_at')->get();

            if (count($transaction->transactionApprovals) === count($transactionApprovalApproved)) {
                $statusChange = 'approved';
                $transaction->current_status = $statusChange;
            }

            if ($statusChange) {
                $transactionStatus = new TransactionStatus();
                $transactionStatus->transaction_id = $transaction->id;
                $transactionStatus->title = $statusChange;
                $transactionStatus->save();
            }
            $transaction->save();

            DB::commit();
            return resultFunction("Approval / reject processing successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-Ap: catch " . $e->getMessage());
        }
    }

    public function publish($id) {
        try {
            DB::beginTransaction();
            $transaction = Transaction::with(['transactionApprovals'])->find($id);
            if (!$transaction) return resultFunction("Err code TR-Ap: transaction not found for ID " . $id);

            if ($transaction->current_status !== 'requested')  return resultFunction("Err code TR-Ap: transaction is not requested status for ID " . $id);

            $transactionStatus = new TransactionStatus();
            $transactionStatus->transaction_id = $transaction->id;
            $transactionStatus->title = "published";
            $transactionStatus->save();

            $transaction->current_status = 'published';
            $transaction->save();

            DB::commit();
            return resultFunction("Approval / reject processing successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-Ap: catch " . $e->getMessage());
        }
    }

    public function setTax($id, $itemId, $data) {
        try {
            DB::beginTransaction();
            $transaction = Transaction::with(['transactionApprovals'])->find($id);
            if (!$transaction) return resultFunction("Err code TR-ST: transaction not found for ID " . $id);

            $transactionItem = TransactionItem::where('id', $itemId)->where('transaction_id', $id)->first();
            if (!$transactionItem) return resultFunction("Err code TR-ST: transaction item not found for ID " . $id);

            $transactionApproval = $transaction->transactionApprovals->where('title', 'Tax Admin')->first();
            if ($transactionApproval->approved_at OR $transactionApproval->rejected_at)  return resultFunction("Err code TR-ST: You can't tax coa when approval is set");

            $respG = $this->generateAmount($data['input_amount'], $data['tax_amount'], $data['ppn_amount'], $data['pph_amount'], $data['tax_type']);
            $transactionItem->tax_type = $data['tax_type'];
            $transactionItem->ppn_label = $data['ppn_label'];
            $transactionItem->pph_label = $data['pph_label'];
            $transactionItem->ppn = $respG['ppn'];
            $transactionItem->pph = $respG['pph'];
            $transactionItem->dpp = $respG['dpp'];
            $transactionItem->amount_tax = $data['tax_amount'];
            $transactionItem->total_amount = $respG['total'];
            $transactionItem->save();

            $transactionItems = TransactionItem::where('transaction_id', $transaction->id)->get();
            $ppnTotal = 0;
            $pphTotal = 0;
            $dppTotal = 0;
            $amountTotal = 0;
            foreach ($transactionItems as $tr) {
                $ppnTotal = $ppnTotal + $tr->ppn;
                $pphTotal = $pphTotal + $tr->pph;
                $dppTotal = $dppTotal + $tr->dpp;
                $amountTotal = $amountTotal + $tr->total_amount;
            }

            $transaction->ppn = $ppnTotal;
            $transaction->pph = $pphTotal;
            $transaction->dpp = $dppTotal;
            $transaction->total_amount = $amountTotal;
            $transaction->save();

            DB::commit();
            return resultFunction("Tax has created", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-ST: catch " . $e->getMessage());
        }
    }

    public function generateAmount($input, $inputTax, $ppnPercentage, $pphPercentage, $type) {
        $dpp = 0;
        $ppn = 0;
        $pph = 0;
        $total = $inputTax;

        if ($type === 'ppn_gross') {
            $taxPercent = 1 . $pphPercentage - $pphPercentage;
            $dpp = (100 / $taxPercent) * $inputTax;
            $ppn = $dpp * ($ppnPercentage / 100);
            $pph = $dpp * ($pphPercentage / 100);
            $total = $dpp + $ppn - $pph;
        } elseif ($type === 'ppn_reduce') {
            $taxPercent = 1 . $pphPercentage;
            $dpp = (100 / $taxPercent) * $inputTax;
            $ppn = $dpp * ($ppnPercentage / 100);
            $pph = $dpp * ($pphPercentage / 100);
            $total = $dpp + $ppn - $pph;
        } else if ($type === 'exclude') {
            $dpp = $inputTax;
            $ppn = $dpp * ($ppnPercentage / 100);
            $pph = $dpp * ($pphPercentage / 100);
            if ($inputTax < $input) {
                $total = $dpp + $ppn - $pph + $input;
            } else {
                $total = $dpp + $ppn - $pph;
            }
        }
        return [
            "dpp" => $dpp,
            "ppn" => $ppn,
            "pph" => $pph,
            "total" => $total
        ];
    }

    public function setCoa($id, $itemId, $data) {
        try {
            DB::beginTransaction();
            $transaction = Transaction::with(['transactionApprovals'])->find($id);
            if (!$transaction) return resultFunction("Err code TR-ST: transaction not found for ID " . $id);

            $transactionItem = TransactionItem::where('id', $itemId)->where('transaction_id', $id)->first();
            if (!$transactionItem) return resultFunction("Err code TR-ST: transaction item not found for ID " . $id);

            $transactionApproval = $transaction->transactionApprovals->where('title', 'Accounting Admin')->first();
            if ($transactionApproval->approved_at OR $transactionApproval->rejected_at)  return resultFunction("Err code TR-ST: You can't change coa when approval is set");

            TransactionItemCoa::where('transaction_id', $transaction->id)->where('transaction_item_id', $transactionItem->id)->delete();

            $transactionItemCoaData = [];
            $debitTotal = 0;
            $creditTotal = 0;
            foreach ($data as $datum) {
                $transactionItemCoaData[] = [
                    'transaction_id' => $transaction->id,
                    'transaction_item_id' => $transactionItem->id,
                    'account_id' => $datum['coa'],
                    'cashflow_id' => $datum['cashflow'] ?? null,
                    'debit' => $datum['debit'],
                    'credit' => $datum['credit'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $debitTotal = $debitTotal + $datum['debit'];
                $creditTotal = $creditTotal + $datum['credit'];
            }

            if ($debitTotal !== $creditTotal)  return resultFunction("Err code TR-ST: Debit and credit is not same");

            TransactionItemCoa::insert($transactionItemCoaData);

            DB::commit();
            return resultFunction("Coa has created", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-ST: catch " . $e->getMessage());
        }
    }

    public function forcedStatus($id) {
        try {
            DB::beginTransaction();
            $transaction = Transaction::with(['transactionApprovals'])->find($id);
            if (!$transaction) return resultFunction("Err code TR-Ap: transaction not found for ID " . $id);

            if ($transaction->current_status !== 'published')  return resultFunction("Err code TR-Ap: The status is not published, you can't do it");

            foreach ($transaction->transactionApprovals as $approval) {
                if (in_array($approval->title, ['Tax Admin', 'Accounting Admin'])) {
                    $approval->approved_at = null;
                    $approval->rejected_at = null;
                    $approval->save();
                }
            }

            DB::commit();
            return resultFunction("Approval / reject processing successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-Ap: catch " . $e->getMessage());
        }
    }

    public function pushToJurnal($transaction) {
        try {
            DB::beginTransaction();
            $transactionApproveds = Journal::where('company_id', $transaction->company_id)->whereNotNull('approved_at')->count();
            $company = Company::find($transaction->company_id);

            $dateNow = date("Y-m-d H:i:s");

            $voucherNo = $company->voucher_prefix . "-" . date("y").date('m').date('d') . "-" . ($transactionApproveds + 1);
            $journal = new Journal();
            $journal->company_id = $transaction->company_id;
            $journal->transaction_uid = $transaction->transaction_number;
            $journal->voucher_no = $voucherNo;
            $journal->title = $transaction->title;
            $journal->transaction_date = $dateNow;
            $journal->save();

            $journalItems = [];
            foreach ($transaction->transactionItems as $item) {
                foreach ($item->transactionItemCoas as $coa) {
                    $journalItems[] = [
                        'company_id' => $company->id,
                        'journal_id' => $journal->id,
                        'account_id' => $coa->account_id,
                        'cashflow_id' => $coa->cashflow_id,
                        'description' => $item->note,
                        'debit' => $coa->debit,
                        'credit' => $coa->credit,
                        'transaction_date' => $dateNow,
                        'balance' => 0,
                        'is_first_balance' => 0,
                        'created_at' => $dateNow,
                        'updated_at' => $dateNow
                    ];
                }
            }

            JournalItem::insert($journalItems);


            DB::commit();
            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-PTJ: catch " . $e->getMessage());
        }
    }

    public function setMethod($id, $data) {
        try {
            $validator = \Validator::make($data, [
                "method" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code TR-St: " . collect($validator->errors()->all())->implode(" , "));

            $transaction = Transaction::with([])->find($id);
            if (!$transaction) return resultFunction("Err code TR-ST: transaction not found for ID " . $id);

            if ($data['method'] === 'manual') {
                if (!$data['transaction_date']) return resultFunction("Err code TR-ST: transaction date is not found for manual method");
                $transaction->transaction_date = $data['transaction_date'];
            } else {
                $transaction->transaction_date = null;
            }
            $transaction->method = $data['method'];
            $transaction->save();

            return resultFunction("Method has created", true);
        } catch (\Exception $e) {
            return resultFunction("Err code TR-ST: catch " . $e->getMessage());
        }
    }

    public function uploadImage($image)
    {
        try {
            if (!$image) {
                return resultFunction("Err code TR-Ui: Please attach the image");
            }
            if ($image->getError() == 1) {
                return resultFunction('Err code TR-Ui: ' . $image->getErrorMessage());
            }

            return (new DigitalOceanService())->uploadImageToDO($image, "transaction");
        } catch (\Exception $e) {
            return resultFunction("Err code TR-Ui: catch " . $e->getMessage());
        }
    }
}