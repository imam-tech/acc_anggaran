<?php

namespace App\Repositories;

use App\Imports\CoaImport;
use App\Models\CashAndBank;
use App\Models\Coa;
use App\Models\CoaCategory;
use App\Models\CoaPosting;
use App\Models\Journal;
use App\Models\JournalItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CoaRepository {
    public function store($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "category" => "required",
                "posting" => "required",
                "account_number" => "required",
                "account_name" => "required",
                "account_type" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code CR-S: " . collect($validator->errors()->all())->implode(" , "));

            $category = CoaCategory::find($data['category']);
            if (!$category) return resultFunction("Err code CR-S: category not found for ID " . $data['category']);

            $posting = CoaPosting::find($data['posting']);
            if (!$posting) return resultFunction("Err code CR-S: posting not found for ID " . $data['category']);

            $message = "Creating";
            if ($data['id']) {
                $coa = Coa::find($data['id']);
                if (!$coa) return resultFunction("Err code CR-S: coa not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $coa = new Coa();
            }
            $coa->company_id = $companyId;
            $coa->category_id = $category->id;
            $coa->posting_id = $posting->id;
            $coa->account_code = $data['account_number'] . '-' . $data['account_name'];
            $coa->account_number = $data['account_number'];
            $coa->account_name = $data['account_name'];
            $coa->description = $data['description'] ?? null;
            $coa->account_type = $data['account_type'];
            $coa->is_active = $data['is_active'];
            $coa->save();

            if (!$data['id']) {
                if (in_array($category->name, ['KAS DAN SETARA KAS', "KAS", "BANK", "HUTANG BANK & LEMBAGA KEUANGAN"])) {
                    $cashBank = new CashAndBank();
                    $cashBank->company_id = $companyId;
                    $cashBank->type = in_array($category->name, ['KAS DAN SETARA KAS', "KAS"]) ? "Cash" : ($category->name === 'BANK' ? "Bank" : "Credit Card");
                    $cashBank->coa_id = $coa->id;
                    $cashBank->save();
                }
            }

            return resultFunction($message . " coa is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-S: catch " . $e->getMessage());
        }
    }

    public function detailCategory($id) {
        try {
            $category = CoaCategory::find($id);
            if (!$category) return resultFunction("Err code CR-DC: category not found");

            return resultFunction("", true, $category);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-DC: catch " . $e->getMessage());
        }
    }

    public function detailAllCoa($categoryId) {
        try {

            $query = "
                SELECT 
                    cat.id as parent, child.id as children, 
                    child1.id as children1, child2.id as children2
                FROM coa_categories as cat
                LEFT JOIN coa_categories as child ON cat.id = child.parent_id
                LEFT JOIN coa_categories as child1 ON child.id = child1.parent_id
                LEFT JOIN coa_categories as child2 ON child1.id = child2.parent_id
                where cat.id = " . $categoryId ."
            ";
            $categoryIds = DB::SELECT($query);

            $finalCategoryIds = $this->reArrangeCategory($categoryIds);

            $queryCategory = count($finalCategoryIds) > 0 ? implode(', ', $finalCategoryIds) : '';

            $queryJournal = "
            SELECT c.*, (SUM(item.debit) - SUM(item.credit)) as balance, posting.name as posting_label, category.name as category_name FROM coas as c 
                LEFT JOIN journal_items as item ON item.account_id = c.id
                LEFT JOIN coa_postings as posting ON posting.id = c.posting_id
                LEFT JOIN coa_categories as category ON category.id = c.category_id
                WHERE c.category_id IN (${queryCategory})
                AND item.deleted_at IS NULL
                GROUP BY c.id
            ";

            $resp = DB::SELECT($queryJournal);

            return resultFunction("", true, $resp);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-DC: catch " . $e->getMessage());
        }
    }

    public function reArrangeCategory($data) {
        $result = [];
        foreach ($data as $x) {
            if ($x->parent AND !in_array($x->parent, $result)) {
                $result[] = $x->parent;
            }
            if ($x->children AND !in_array($x->children, $result)) {
                $result[] = $x->children;
            }
            if ($x->children1 AND !in_array($x->children1, $result)) {
                $result[] = $x->children1;
            }
            if ($x->children2 AND !in_array($x->children2, $result)) {
                $result[] = $x->children2;
            }
        }
        return $result;
    }

    public function journalItemsCategory($filters) {
        try {
            $coa = Coa::with(['coaPosting', 'coaCategory'])->find($filters['account']);
            if (!$coa) return resultFunction("Err code CR-DC: coa not found");

            $where = '';
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'requested') {
                    $where = " AND (journal.approved_at is null and journal.rejected_at is null) ";
                }

                if ($filters['status'] == 'approved') {
                    $where = " AND (journal.approved_at is null) ";
                }

                if ($filters['status'] == 'rejected') {
                    $where = " AND (journal.rejected_at is null) ";
                }
            }
            $startDate = date("Y") . "-01-01 00:00:00";

            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT 
                    c.account_number, c.account_type, item.*, SUM(item.debit) as total_debit, SUM(item.credit) AS total_credit, journal.id as journal_id,
                    journal.transaction_uid as invoice, journal.id as journal_id, journal.title as journal_title, journal.transaction_date AS transaction_date, journal.rejected_at AS rejectedAt
                FROM journal_items as item
                LEFT JOIN journals as journal ON journal.id = item.journal_id
                LEFT JOIN coas as c ON c.id = item.account_id
                WHERE item.account_id = ".$filters['account']."
                AND item.transaction_date >= '".$startDate."'
                AND item.deleted_at IS NULL AND journal.deleted_at IS NULL ".$where."
                GROUP BY item.journal_id ORDER BY item.transaction_date DESC
            ";
            $queryData = DB::SELECT($query);

            $queryData = array_reverse($queryData);
            $currentBalance = 0;

            foreach ($queryData as $x) {
                if (!$x->rejectedAt) {
                    if ($x->is_first_balance == 1) {
                        $currentBalance = $currentBalance + $x->total_debit;
                    } else {
                        if ($x->account_type === 'Debit') {
                            $currentBalance = ($currentBalance + $x->total_debit) - $x->total_credit;
                        } else {
                            $currentBalance = ($currentBalance - $x->total_debit) + $x->total_credit;
                        }
                    }
                    $x->balance = $currentBalance;
                }
            }
            $queryData = array_reverse($queryData);

            return resultFunction("", true, [
                'coa' => $coa,
                'transactions' => $queryData
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-DC: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $coa = Coa::with(['coaCategory'])->find($id);
            if (!$coa) return resultFunction("Err code CR-D: coa not found");

            if (in_array($coa->coaCategory->name, ['KAS DAN SETARA KAS', "KAS", "BANK", "HUTANG BANK & LEMBAGA KEUANGAN"])) {
                $cashbank = CashAndBank::with([])
                    ->where('coa_id', $coa->id)
                    ->first();
                if ($cashbank) {
                    $cashbank->delete();
                }
            }

            $journalItem = JournalItem::where('account_id', $coa->id)->first();
            if ($journalItem) return resultFunction("Err code CR-D: the coa can't be deleted because it has the item.");
            $coa->delete();

            DB::commit();

            return resultFunction("Deleting coa is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-D: catch " . $e->getMessage());
        }
    }

    public function setInitialBalance($id, $amount) {
        try {
            $coa = Coa::find($id);
            if (!$coa) return resultFunction("Err code CR-DC: coa not found");
            $dateNow = date("Y-m-d H:i:s");

            $journalItem = JournalItem::where('account_id', $id)->where('is_first_balance', 1)->first();
            if (!$journalItem) {
                $journal = new Journal();
                $journal->company_id = 1;
                $journal->transaction_uid = "INITIAL BALANCE";
                $journal->title = "INITIAL BALANCE";
                $journal->transaction_date = date("Y") . "-01-01 00:00:00";
                $journal->approved_at = $dateNow;
                $journal->save();

                $journalItem = new JournalItem();
                $journalItem->company_id = 1;
                $journalItem->journal_id = $journal->id;
                $journalItem->account_id =  $coa->id;
                $journalItem->description = "INITIAL BALANCE";
                $journalItem->is_first_balance = 1;
                $journalItem->approved_at = $dateNow;
                $journalItem->debit = 0;
                $journalItem->credit = 0;
                $journalItem->balance = 0;
                $journalItem->transaction_date = date("Y") . "-01-01 00:00:00";
                $journalItem->save();
            }

            $journalItem->debit = $amount;
            $journalItem->balance = $amount;
            $journalItem->save();

            return resultFunction("Initializing balance is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-SIB: catch " . $e->getMessage());
        }
    }

    public function uploadBulk($request, $companyId) {
        try {
            $data = Excel::toArray(new CoaImport, $request->file('file_excel'));

            $dataProcess = [];
            foreach ($data[0] as $key => $datum) {
                if ($key > 0) {
                    $dataProcess[] = $datum;
                }
            }

            $coaCategories = CoaCategory::whereIn('name', array_unique(array_column($dataProcess, 0)))->where('flag', 'pt')->get();
            $postings = CoaPosting::whereIn("name", array_unique(array_column($dataProcess, 1)))->get();

            $paramSave = [];
            foreach ($dataProcess as $process) {
                $categorySelect = $coaCategories->where('name', strtoupper($process[0]))->first();
                if (!$categorySelect) return resultFunction("Err code CR-UB: coa category  is not found");

                $postingSelect = $postings->where('name', $process[1])->first();
                if (!$postingSelect) return resultFunction("Err code CR-UB: posting  is not found");

                $paramSave[] = [
                    'company_id' => $companyId,
                    'category_id' => $categorySelect->id,
                    'posting_id' => $postingSelect->id,
                    'account_code' => $process[2].'-'.$process[3],
                    'account_number' => $process[2],
                    'account_name' => $process[3],
                    'description' => '',
                    'account_type' => $process[4],
                    'is_active' => 1
                ];
            }
            Coa::insert($paramSave);

            return resultFunction(" coa bulk is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-S: catch " . $e->getMessage());
        }
    }
}