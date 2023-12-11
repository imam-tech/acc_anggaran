<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Repositories\ManufactureRepository;
use Illuminate\Http\Request;

class ManufactureController extends Controller {
    protected $manufactureRepo;

    public function __construct()
    {
        $this->manufactureRepo = new ManufactureRepository();
    }

    public function indexMaterial() {
        $materials = Material::with([]);
        $materials = $materials->get();
        return response()->json($materials);
    }

    public function storeMaterial(Request $request) {
        return response()->json($this->manufactureRepo->storeMaterial($request->all(), $request->header('company_id')));
    }
}