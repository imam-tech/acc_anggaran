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
        return response()->json($this->productRepo->storeUnit($request->all(), $request->header('company_id')));
    }

    public function deleteUnit($id) {
        return response()->json($this->productRepo->deleteUnit($id));
    }

    public function indexCategory(Request $request) {
        $filters = $request->only(['is_archive']);
        $productCategories = ProductCategory::with(['product']);

        $productCategories = $productCategories->where('company_id', $request->header('company_id'));
        if (!empty($filters['is_archive'])) {
            $productCategories = $productCategories->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $productCategories = $productCategories->orderBy('id', 'desc')->get();
        return response()->json($productCategories);
    }

    public function storeCategory(Request $request) {
        return response()->json($this->productRepo->storeCategory($request, $request->header('company_id')));
    }

    public function deleteCategory($id) {
        return response()->json($this->productRepo->deleteCategory($id));
    }

    public function store(Request $request) {
        return response()->json($this->productRepo->store($request, $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only(['is_sale', 'is_purchase', 'is_archive']);
        $products = Product::with(['category', 'unit', 'sale_tax', 'purchase_tax', 'sale_product', 'purchase_product']);

        if (!empty($filters['is_sale'])) $products = $products->where('is_sale', $filters['is_sale']);
        if (!empty($filters['is_purchase'])) $products = $products->where('is_purchase', $filters['is_purchase']);

        if (!empty($filters['is_archive'])) {
            $products = $products->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $products = $products->where('company_id', $request->header('company_id'));
        $products = $products->orderByDesc('id')->get();
        return response()->json($products);
    }

    public function detail($id, Request $request) {
        return response()->json($this->productRepo->detail($id, $request->header('company_id')));
    }

    public function delete($id, Request $request) {
        return response()->json($this->productRepo->delete($id, $request->header('company_id')));
    }

    public function archiveUnit($id) {
        return response()->json($this->productRepo->archiveUnit($id));
    }

    public function archiveCategory($id) {
        return response()->json($this->productRepo->archiveCategory($id));
    }

    public function archive($id) {
        return response()->json($this->productRepo->archive($id));
    }
}