<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SettingFlip;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

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

        $settingFlips = $settingFlips->orderBy('id', 'desc')->get();
        return response()->json($settingFlips);
    }

    public function storeFlip(Request $request) {
        return response()->json($this->settingRepo->storeFlip($request->all()));
    }

    public function deleteFlip($id = null) {
        return response()->json($this->settingRepo->deleteFlip($id));
    }
}