<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\AccountingRepository;
use Illuminate\Http\Request;

class AccountingController extends Controller {
    protected $accountingRepo;

    public function __construct()
    {
        $this->accountingRepo = new AccountingRepository();
    }

    public function indexRole() {
        $taxes = Role::with([]);

        $taxes = $taxes->orderBy('id', 'desc')->get();
        return response()->json($taxes);
    }

    public function changeRole(Request $request) {
        return response()->json($this->accountingRepo->changeRole($request->all()));
    }
}