<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;

class PurchaseController extends Controller {
    protected $purchaseRepo;

    public function __construct()
    {
        $this->purchaseRepo = new PurchaseRepository();
    }

    public function storeSupplier(Request $request) {
        return response()->json($this->purchaseRepo->storeSupplier($request->all(), $request->header('company_id')));
    }

    public function indexSupplier(Request $request) {
        $filters = $request->only([]);
        $customers = Supplier::with([]);

        $customers = $customers->where('company_id', $request->header('company_id'));
        $customers = $customers->orderBy('id', 'desc')->get();
        return response()->json($customers);
    }

    public function detailSupplier($id) {
        return response()->json($this->purchaseRepo->detailSupplier($id));
    }

    public function getProductMaterial($type) {
        $responses = [];
        if ($type == 'Product') {
            $products = Product::with([])->get();
            foreach ($products as $product) {
                $responses[] = [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'unit' => $product->unit,
                    'image' => $product->product_image
                ];
            }
        } else {
            $materials = Material::with([])->get();
            foreach ($materials as $material) {
                $responses[] = [
                    'id' => $material->id,
                    'name' => $material->name,
                    'unit' => $material->unit,
                    'image' => $material->image
                ];
            }
        }

        return response()->json($responses);
    }

    public function store(Request $request) {
        return response()->json($this->purchaseRepo->store($request->all(), $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only([]);
        $purchases = Purchase::with(['purchase_items', 'supplier']);

        $purchases = $purchases->where('company_id', $request->header('company_id'));
        $purchases = $purchases->orderBy('id', 'desc')->get();
        return response()->json($purchases);
    }

    public function detail($id) {
        return response()->json($this->purchaseRepo->detail($id));
    }

    public function approve($id) {
        return response()->json($this->purchaseRepo->approve($id));
    }
}