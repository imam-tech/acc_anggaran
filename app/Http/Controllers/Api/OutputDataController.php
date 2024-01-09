<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use App\Models\CoaCategory;
use App\Models\CoaPosting;
use App\Models\Journal;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Repositories\OutputDataRepository;
use Illuminate\Http\Request;

class OutputDataController extends Controller {
    protected $outputDataRepo;

    public function __construct()
    {
        $this->outputDataRepo = new OutputDataRepository();
    }

    public function balanceProfit(Request $request) {
        return response()->json($this->outputDataRepo->balanceProfit($request->all(), $request->header('company_id')));
    }

    public function cashflow(Request $request) {
        return response()->json($this->outputDataRepo->cashflow($request->all(), $request->header('company_id')));
    }

    public function cashflowInitial(Request $request) {
        return response()->json($this->outputDataRepo->cashflowInitial($request->all(), $request->header('company_id')));
    }

    public function journal(Request $request) {
        return response()->json($this->outputDataRepo->journal($request->all(), $request->header('company_id')));
    }

    public function generalLedger(Request $request) {
        return response()->json($this->outputDataRepo->generalLedger($request->all(), $request->header('company_id')));
    }
}