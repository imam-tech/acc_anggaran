<?php

namespace App\Http\Controllers\Api\InputData;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use App\Models\CoaCategory;
use App\Models\CoaPosting;
use App\Models\Journal;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Repositories\JournalRepository;
use Illuminate\Http\Request;

class JournalController extends Controller {
    protected $journalRepo;

    public function __construct()
    {
        $this->journalRepo = new JournalRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['start_date', 'end_date', 'transaction_uid', 'title', 'status']);
        $journals = Journal::with(['journalItems']);

        if (!empty($filters['start_date'])) {
            $journals = $journals->where('transaction_date', '>=', $filters['start_date'] . " 00:00:00");
        }

        if (!empty($filters['end_date'])) {
            $journals = $journals->where('transaction_date', '<=', $filters['end_date'] . " 23:59:59");
        }

        if (!empty($filters['transaction_uid'])) {
            $journals = $journals->where('transaction_uid', 'LIKE', "%" . $filters['transaction_uid'] . "%");
        }

        if (!empty($filters['title'])) {
            $journals = $journals->where('title', 'LIKE', "%" . $filters['title'] . "%");
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'approved') {
                $journals = $journals->whereNotNull('approved_at');
            }

            if ($filters['status'] === 'rejected') {
                $journals = $journals->whereNotNull('rejected_at');
            }

            if ($filters['status'] === 'requested') {
                $journals = $journals->whereNull('approved_at')->whereNull('rejected_at');
            }
        }

        $journals = $journals->where('company_id', $request->header('company_id'));
        $journals = $journals->orderBy('id', 'desc')->get();
        return response()->json($journals);
    }

    public function detail($id) {
        return response()->json($this->journalRepo->detail($id));
    }

    public function approval($id, Request $request) {
        return response()->json($this->journalRepo->approval($id, $request->all()));
    }

    public function store(Request $request) {
        return response()->json($this->journalRepo->store($request->all()));
    }

    public function delete($id) {
        return response()->json($this->journalRepo->delete($id));
    }
}