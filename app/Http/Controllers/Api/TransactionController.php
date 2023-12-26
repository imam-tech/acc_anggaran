<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller {
    protected $transactionRepo;

    public function __construct()
    {
        $this->transactionRepo = new TransactionRepository();
    }

    public function indexRole() {
        $transactions = Transaction::with([]);

        $transactions = $transactions->orderBy('id', 'desc')->get();
        return response()->json($transactions);
    }

    public function store(Request $request) {
        return response()->json($this->transactionRepo->store($request->all()));
    }

    public function detail($id = null) {
        return response()->json($this->transactionRepo->detail($id));
    }

    public function delete($id = null) {
        return response()->json($this->transactionRepo->delete($id));
    }

    public function index(Request $request) {
        $filters = $request->only(['company_id', 'status', 'transaction_number', 'all']);
        $transactions = Transaction::with(['project.company', 'userCreatedBy', 'transactionApprovalNulls.user']);

        if (!empty($filters['company_id'])) {
            $transactions = $transactions->where('company_id', $filters['company_id']);
        }
        if (!empty($filters['status'])) {
            $transactions = $transactions->where('current_status', $filters['status']);
        }
        if (!empty($filters['transaction_number'])) {
            $transactions = $transactions->where('transaction_number', 'LIKE', "%" . $filters['transaction_number'] . '%');
        }
        if (isset($filters['all'])) {
            $transactions = $transactions->orderBy('id', 'desc')->get();
        } else {
            $transactions = $transactions->orderBy('id', 'desc')->paginate(25);
        }
        return response()->json($transactions);
    }

    public function approval($id, $status, $itemId) {
        return response()->json($this->transactionRepo->approval($id, $status, $itemId));
    }

    public function publish($id) {
        return response()->json($this->transactionRepo->publish($id));
    }

    public function setTax($id, $itemId, Request $request) {
        return response()->json($this->transactionRepo->setTax($id, $itemId, $request->all()));
    }

    public function setCoa($id, $itemId, Request $request) {
        return response()->json($this->transactionRepo->setCoa($id, $itemId, $request->all()));
    }

    public function forcedStatus($id) {
        return response()->json($this->transactionRepo->forcedStatus($id));
    }

    public function setMethod($id, Request $request) {
        return response()->json($this->transactionRepo->setMethod($id, $request->all()));
    }

    public function uploadImage(Request $request) {
        return response()->json($this->transactionRepo->uploadImage($request));
    }

    public function callbackFlip(Request $request) {
        return response()->json($this->transactionRepo->callbackFlip($request->all()));
    }
}