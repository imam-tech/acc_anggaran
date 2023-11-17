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

    public function index() {
        $taxes = Transaction::with(['project.company', 'userCreatedBy', 'transactionApprovalNulls.user']);

        $taxes = $taxes->orderBy('id', 'desc')->get();
        return response()->json($taxes);
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
}