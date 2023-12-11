<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller {
    protected $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
    }

    public function indexUnit(Request $request) {
        $filters = $request->only([]);
        $productUnits = ProductUnit::with([]);

        $productUnits = $productUnits->where('company_id', $request->header('company_id'));
        $productUnits = $productUnits->orderBy('id', 'desc')->get();
        return response()->json($productUnits);
    }

    public function storeUnit(Request $request) {
        return response()->json($this->productRepo->storeUnit($request->all(), $request->header('company_id')));
    }

    public function deleteUnit($id) {
        return response()->json($this->productRepo->deleteUnit($id));
    }

    public function indexBrand(Request $request) {
        $filters = $request->only([]);
        $productBrands = ProductBrand::with([]);

        $productBrands = $productBrands->where('company_id', $request->header('company_id'));
        $productBrands = $productBrands->get();
        return response()->json($productBrands);
    }

    public function storeBrand(Request $request) {
        return response()->json($this->productRepo->storeBrand($request->all(), $request->header('company_id')));
    }

    public function deleteBrand($id) {
        return response()->json($this->productRepo->deleteBrand($id));
    }

    public function indexCategory(Request $request) {
        $filters = $request->only([]);
        $productCategorys = ProductCategory::with([]);

        $productCategorys = $productCategorys->where('company_id', $request->header('company_id'));
        $productCategorys = $productCategorys->get();
        return response()->json($productCategorys);
    }

    public function storeCategory(Request $request) {
        return response()->json($this->productRepo->storeCategory($request->all(), $request->header('company_id')));
    }

    public function deleteCategory($id) {
        return response()->json($this->productRepo->deleteCategory($id));
    }

    public function store(Request $request) {
        return response()->json($this->productRepo->store($request->all(), $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only([]);
        $productBrands = Product::with([]);

        $productBrands = $productBrands->where('company_id', $request->header('company_id'));
        $productBrands = $productBrands->get();
        return response()->json($productBrands);
    }

    public function detail($id) {
        return response()->json($this->productRepo->detail($id));
    }
}