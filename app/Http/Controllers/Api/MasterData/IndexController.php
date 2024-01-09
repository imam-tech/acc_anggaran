<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\ProductUnit;
use App\Models\Tag;
use App\Repositories\MasterDataRepository;
use Illuminate\Http\Request;

class IndexController extends Controller {
    protected $indexRepo;

    public function __construct()
    {
        $this->indexRepo = new MasterDataRepository();
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
        return response()->json($this->indexRepo->storePm($request->all(), $request->header('company_id')));
    }

    public function deletePm($id = null) {
        return response()->json($this->indexRepo->deletePm($id));
    }

    public function archivePm($id = null) {
        return response()->json($this->indexRepo->archivePm($id));
    }

    public function indexUnit(Request $request) {
        $filters = $request->only(['is_archive']);
        $productUnits = ProductUnit::with(['product']);

        $productUnits = $productUnits->where('company_id', $request->header('company_id'));
        if (!empty($filters['is_archive'])) {
            $productUnits = $productUnits->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $productUnits = $productUnits->orderBy('id', 'desc')->get();
        return response()->json($productUnits);
    }

    public function storeUnit(Request $request) {
        return response()->json($this->indexRepo->storeUnit($request->all(), $request->header('company_id')));
    }

    public function deleteUnit($id) {
        return response()->json($this->indexRepo->deleteUnit($id));
    }

    public function archiveUnit($id) {
        return response()->json($this->indexRepo->archiveUnit($id));
    }

    public function indexTag(Request $request) {
        $filters = $request->only(['is_archive']);
        $productTags = Tag::with([])->withCount(['sales', 'purchases']);

        $productTags = $productTags->where('company_id', $request->header('company_id'));
        if (!empty($filters['is_archive'])) {
            $productTags = $productTags->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $productTags = $productTags->orderBy('id', 'desc')->get();
        return response()->json($productTags);
    }

    public function storeTag(Request $request) {
        return response()->json($this->indexRepo->storeTag($request->all(), $request->header('company_id')));
    }

    public function deleteTag($id) {
        return response()->json($this->indexRepo->deleteTag($id));
    }

    public function archiveTag($id) {
        return response()->json($this->indexRepo->archiveTag($id));
    }
}