<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashAndBank;
use App\Repositories\CashAndBankRepository;
use Illuminate\Http\Request;

class CashAndBankController extends Controller {
    protected $cashAndBankRepo;

    public function __construct()
    {
        $this->cashAndBankRepo = new CashAndBankRepository();
    }

    public function store(Request $request) {
        return response()->json($this->cashAndBankRepo->store($request->all(), $request->header('company_id')));
    }

    public function index(Request $request) {
        return response()->json($this->cashAndBankRepo->index($request->header('company_id')));
    }

    public function detail($id) {
        return response()->json($this->cashAndBankRepo->detail($id));
    }
}