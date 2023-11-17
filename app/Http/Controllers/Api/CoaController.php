<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use App\Models\Coa;
use App\Models\CoaCategory;
use App\Models\CoaPosting;
use App\Repositories\CoaRepository;
use Illuminate\Http\Request;

class CoaController extends Controller {
    protected $coaRepo;

    public function __construct()
    {
        $this->coaRepo = new CoaRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['is_active', 'category_id']);
        $coas = Coa::with(['coaCategory', 'coaPosting']);

        if (!empty($filters['is_active'])) {
            $coas = $coas->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['category_id'])) {
            $coas = $coas->where('category_id', $filters['category_id']);
        }
        $coas = $coas->get();
        return response()->json($coas);
    }

    public function indexCategory(Request $request) {
        $filters = $request->only(['flag']);
        $coaCategories = CoaCategory::with([]);

        if (!empty($filters['is_active'])) {
            $coaCategories = $coaCategories->where('flag', $filters['flag']);
        }

        $coaCategories = $coaCategories->get();
        return response()->json($coaCategories);
    }

    public function indexPosting() {
        $coaPostings = CoaPosting::with([]);

        $coaPostings = $coaPostings->get();
        return response()->json($coaPostings);
    }

    public function store(Request $request) {
        return response()->json($this->coaRepo->store($request->all()));
    }

    public function indexCashflow() {
        $coaPostings = Cashflow::with([]);

        $coaPostings = $coaPostings->get();
        return response()->json($coaPostings);
    }

    public function indexCategoryList(Request $request) {
        $filters = $request->only(['flag']);
        $coaCategories = CoaCategory::with(['childrens.childrens.childrens']);

        if (!empty($filters['flag'])) {
            $coaCategories = $coaCategories->where('flag', $filters['flag']);
        }

        $coaCategories = $coaCategories->whereNull('parent_id')->get();
        return response()->json($coaCategories);
    }

    public function detailCategory($id) {
        return response()->json($this->coaRepo->detailCategory($id));
    }

    public function detailAllCoa($categoryId) {
        return response()->json($this->coaRepo->detailAllCoa($categoryId));
    }

    public function journalItemsCategory(Request $request) {
        $filters = $request->only(['account', 'status']);
        return response()->json($this->coaRepo->journalItemsCategory($filters));
    }
}