<?php

namespace App\Repositories;

use App\Models\Journal;
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
}