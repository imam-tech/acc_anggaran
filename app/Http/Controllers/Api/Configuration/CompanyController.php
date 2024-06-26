<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller {
    protected $companyRepo;

    public function __construct()
    {
        $this->companyRepo = new CompanyRepository();
    }

    public function index() {
        $companies = Company::with(['projects', 'settingViews', 'max_company']);

        $companies = $companies->where('app_id', Auth::user()->app_id)->get();
        return response()->json($companies);
    }

    public function store(Request $request) {
        return response()->json($this->companyRepo->store($request->all()));
    }

    public function delete($id = null) {
        return response()->json($this->companyRepo->delete($id));
    }

    public function detail($id = null) {
        return response()->json($this->companyRepo->detail($id));
    }

    public function adminApproval(Request $request) {
        return response()->json($this->companyRepo->adminApproval($request->all()));
    }

    public function pushPlugin($id, Request $request) {
        return response()->json($this->companyRepo->pushPlugin($id, $request->all()));
    }

    public function changeSettingFlip($id, $settingFlipId) {
        return response()->json($this->companyRepo->changeSettingFlip($id, $settingFlipId));
    }
}