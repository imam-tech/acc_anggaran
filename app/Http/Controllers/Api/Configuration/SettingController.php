<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SettingFlip;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller {
    protected $settingRepo;

    public function __construct()
    {
        $this->settingRepo = new SettingRepository();
    }

    public function indexFlip(Request $request) {
        $filters = $request->only(['type']);
        $settingFlips = SettingFlip::with([]);

        if (!empty($filters['type'])) {
            $settingFlips = $settingFlips->where('type', $filters['type']);
        }

        $settingFlips = $settingFlips->where('app_id', Auth::user()->app_id)->orderBy('id', 'desc')->get();
        return response()->json($settingFlips);
    }

    public function storeFlip(Request $request) {
        return response()->json($this->settingRepo->storeFlip($request->all()));
    }

    public function deleteFlip($id = null) {
        return response()->json($this->settingRepo->deleteFlip($id));
    }

    public function indexRole() {
        $roles = Role::with(['rolePermissions.permission']);
        return response()->json($roles->get());
    }

    public function indexPermission() {
        $roles = Permission::with(['rolePermissions.role']);
        return response()->json($roles->get());
    }

    public function indexPm(Request $request) {
        $filters = $request->only(['is_archive']);
        $pms = PaymentMethod::with(['sales_payment', 'purchase_payment']);
        if (!empty($filters['is_archive'])) {
            $pms = $pms->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $pms = $pms->orderBy('id', 'desc')->get();
        return response()->json($pms);
    }

    public function storePm(Request $request) {
        return response()->json($this->settingRepo->storePm($request->all()));
    }

    public function deletePm($id = null) {
        return response()->json($this->settingRepo->deletePm($id));
    }

    public function archivePm($id = null) {
        return response()->json($this->settingRepo->archivePm($id));
    }
}