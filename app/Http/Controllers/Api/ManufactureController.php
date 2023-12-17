<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ManufactureProduct;
use App\Models\Material;
use App\Models\SemiFinishedMaterial;
use App\Repositories\ManufactureRepository;
use Illuminate\Http\Request;

class ManufactureController extends Controller {
    protected $manufactureRepo;

    public function __construct()
    {
        $this->manufactureRepo = new ManufactureRepository();
    }

    public function indexMaterial() {
        $materials = Material::with(['material_histories']);
        $materials = $materials->orderByDesc('id')->get();
        return response()->json($materials);
    }

    public function storeMaterial(Request $request) {
        return response()->json($this->manufactureRepo->storeMaterial($request, $request->header('company_id')));
    }

    public function getSemiFinishedMaterial($type) {
        $responses = [];
        if ($type == 'Semi Finished Material') {
            $products = SemiFinishedMaterial::with(['semi_finished_material_items.material'])->get();
            foreach ($products as $product) {
                $responses[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'items' => $product->semi_finished_material_items,
                ];
            }
        }

        return response()->json($responses);
    }

    public function storeSemiFinishedMaterial(Request $request) {
        return response()->json($this->manufactureRepo->storeSemiFinishedMaterial($request->all(), $request->header('company_id')));
    }

    public function storeProduct(Request $request) {
        return response()->json($this->manufactureRepo->storeProduct($request->all(), $request->header('company_id')));
    }

    public function indexProduct(Request $request) {
        $filters = $request->only(['status']);
        $manufactureProducts = ManufactureProduct::with(['manufacture_product_details.manufacture_product_detail_items']);
        if (!empty($filters['status'])) {
            $manufactureProducts = $manufactureProducts->where('status', $filters['status']);
        }
        $manufactureProducts = $manufactureProducts->orderByDesc('id')->get();
        return response()->json($manufactureProducts);
    }

    public function detailProduct($id) {
        return response()->json($this->manufactureRepo->detailProduct($id));
    }

    public function indexSemiFinishedMaterial() {
        $semiFinishedMaterials = SemiFinishedMaterial::with(['semi_finished_material_items.material']);
        $semiFinishedMaterials = $semiFinishedMaterials->orderByDesc('id')->get();
        return response()->json($semiFinishedMaterials);
    }

    public function approveProduct($id) {
        return response()->json($this->manufactureRepo->approveProduct($id));
    }
}