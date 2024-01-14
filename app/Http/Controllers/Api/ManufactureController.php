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

    public function indexMaterial(Request $request) {
        $filters = $request->only(['is_archive']);
        $materials = Material::with(['semi_finished_material_items']);
        if (!empty($filters['is_archive'])) {
            $materials = $materials->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $materials = $materials->where('company_id', $request->header('company_id'))->orderByDesc('id')->get();
        return response()->json($materials);
    }

    public function storeMaterial(Request $request) {
        return response()->json($this->manufactureRepo->storeMaterial($request, $request->header('company_id')));
    }

    public function getSemiFinishedMaterial() {
        $responses = [];
        $products = SemiFinishedMaterial::with(['semi_finished_material_items.material'])->where('is_archive', 0)->orderBy('id', 'desc')->get();
        foreach ($products as $product) {
            $responses[] = [
                'id' => $product->id,
                'name' => $product->name,
                'items' => $product->semi_finished_material_items,
            ];
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
        $manufactureProducts = $manufactureProducts->where('company_id', $request->header('company_id'));
        $manufactureProducts = $manufactureProducts->orderByDesc('id')->get();
        return response()->json($manufactureProducts);
    }

    public function detailProduct($id) {
        return response()->json($this->manufactureRepo->detailProduct($id));
    }

    public function indexSemiFinishedMaterial(Request $request) {
        $semiFinishedMaterials = SemiFinishedMaterial::with(['semi_finished_material_items.material', 'manufacture_product_details']);
        $semiFinishedMaterials = $semiFinishedMaterials->where('company_id', $request->header('company_id'));
        $semiFinishedMaterials = $semiFinishedMaterials->orderByDesc('id')->get();
        return response()->json($semiFinishedMaterials);
    }

    public function approveProduct($id) {
        return response()->json($this->manufactureRepo->approveProduct($id));
    }

    public function deleteMaterial($id) {
        return response()->json($this->manufactureRepo->deleteMaterial($id));
    }

    public function deleteSemiFinishedMaterial($id) {
        return response()->json($this->manufactureRepo->deleteSemiFinishedMaterial($id));
    }

    public function deleteProduct($id) {
        return response()->json($this->manufactureRepo->deleteProduct($id));
    }

    public function archiveMaterial($id) {
        return response()->json($this->manufactureRepo->archiveMaterial($id));
    }

    public function archiveSemiFinishedMaterial($id) {
        return response()->json($this->manufactureRepo->archiveSemiFinishedMaterial($id));
    }
}