<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Journal;
use App\Models\JournalItem;
use DateTime;
use Illuminate\Support\Facades\DB;

class JournalRepository {
    public function detail($id) {
        try {
            $journal = Journal::with(['journalItems.account', 'journalItems.cashflow'])->find($id);
            if (!$journal) return resultFunction("Err code JR-D: journal not found for ID " . $id);

            return resultFunction("", true, $journal);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function approval($id, $data) {
        try {
            DB::beginTransaction();
            $validator = \Validator::make($data, [
                "status" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code JR-D: " . collect($validator->errors()->all())->implode(" , "));

            $journal = Journal::with(['journalItems'])->find($id);
            if (!$journal) return resultFunction("Err code JR-D: journal not found for ID " . $id);

            if ($journal->approved_at OR $journal->rejected_at) return resultFunction("Err code JR-D: journal is already processed");

            $dateNow = date("Y-m-d H:i:s");
            if ($data['status'] === 'approved') {
                $journal->approved_at = $dateNow;
            } else {
                $journal->rejected_at = $dateNow;
                if (isset($data['note'])) {
                    $journal->rejected_note = $data['note'] ?? null;
                }
            }
            $journal->save();

            foreach ($journal->journalItems as $item) {
                if ($data['status'] === 'approved') {
                    $item->approved_at = $dateNow;
                } else {
                    $item->rejected_at = $dateNow;
                }
                $item->save();
            }

            DB::commit();
            return resultFunction("Approve / reject successfully", true, $journal);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function store($data) {
        try {
            DB::beginTransaction();
            $validator = \Validator::make($data, [
                "company_id" => "required",
                "project_id" => "required",
                "transaction_no" => "required",
                "transaction_date" => "required",
                "items" => "required"
            ]);

            if ($validator->fails()) return resultFunction("Err code JR-S: " . collect($validator->errors()->all())->implode(" , "));

            $company = Company::find($data['company_id']);

            $transactionApproveds = Journal::where('company_id', $company->id)->whereNotNull('approved_at')->count();

            $dateNow = date("Y-m-d H:i:s");

            $voucherNo = $company->voucher_prefix . "-" . date("y").date('m').date('d') . "-" . ($transactionApproveds + 1);
            if ($data['id']) {
                $journal = Journal::find($data['id']);
            } else {
                $journal = new Journal();
            }
            $journal->company_id = $company->id;
            $journal->project_id = $data['project_id'];
            $journal->transaction_uid = $data['transaction_no'];
            $journal->voucher_no = $voucherNo;
            $journal->title = "manual-input-" . $data['transaction_no'];
            $journal->transaction_date = $data['transaction_date'];
            $journal->save();

            $journalItems = [];
            $debit = 0;
            $credit = 0;
            foreach ($data['items'] as $item) {
                $debit = $debit + $item['debit'];
                $credit = $credit + $item['credit'];
                $journalItems[] = [
                    'company_id' => $company->id,
                    'project_id' => $data['project_id'],
                    'journal_id' => $journal->id,
                    'account_id' => $item['coa'],
                    'cashflow_id' => $item['cashflow'],
                    'description' => $item['description'] ?? "",
                    'debit' => $item['debit'],
                    'credit' => $item['credit'],
                    'transaction_date' => $data['transaction_date'],
                    'balance' => 0,
                    'is_first_balance' => 0,
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow
                ];
            }

            if ($debit !== $credit)  return resultFunction("Err code JR-S: debit and credit is not same amount");

            JournalItem::where('journal_id', $journal->id)->delete();

            JournalItem::insert($journalItems);

            DB::commit();
            return resultFunction("Creating / updating journal successfully", true, $journal);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-S: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $journal = Journal::with([])->find($id);
            if (!$journal) return resultFunction("Err code JR-De: journal not found for ID " . $id);

            $journal->delete();

            JournalItem::where('journal_id', $journal->id)->delete();

            DB::commit();
            return resultFunction("", true, $journal);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-De: catch " . $e->getMessage());
        }
    }
}