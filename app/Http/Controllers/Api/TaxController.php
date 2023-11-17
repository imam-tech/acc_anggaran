<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Repositories\TaxRepository;
use Illuminate\Http\Request;

class TaxController extends Controller {
    protected $taxRepo;

    public function __construct()
    {
        $this->taxRepo = new TaxRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['type']);
        $taxes = Tax::with([]);

        if (!empty($filters['type'])) {
            $taxes = $taxes->where('type', $filters['type']);
        }

        $taxes = $taxes->orderBy('id', 'desc')->get();
        return response()->json($taxes);
    }

    public function store(Request $request) {
        return response()->json($this->taxRepo->store($request->all()));
    }

    public function delete($id = null) {
        return response()->json($this->taxRepo->delete($id));
    }

    public function detail($id = null) {
        return response()->json($this->taxRepo->detail($id));
    }
}