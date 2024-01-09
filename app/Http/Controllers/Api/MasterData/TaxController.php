<?php

namespace App\Http\Controllers\Api\MasterData;

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
        $filters = $request->only(['type', 'is_transaction', 'is_archive']);
        $taxes = Tax::with(['sell_coa', 'buy_coa', 'sale_product', 'purchase_product']);

        if (!empty($filters['type'])) {
            $taxes = $taxes->where('type', $filters['type']);
        }
        if (!empty($filters['is_archive'])) {
            $taxes = $taxes->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }

        if (!empty($filters['is_transaction'])) {
            $taxes = $taxes->where('company_id', $filters['is_transaction']);
        } else {
            $taxes = $taxes->where('company_id', $request->header('company_id'));
        }

        $taxes = $taxes->orderBy('id', 'desc')->get();
        return response()->json($taxes);
    }

    public function store(Request $request) {
        return response()->json($this->taxRepo->store($request->all(), $request->header('company_id')));
    }

    public function delete($id = null) {
        return response()->json($this->taxRepo->delete($id));
    }

    public function detail($id = null) {
        return response()->json($this->taxRepo->detail($id));
    }

    public function archive($id = null) {
        return response()->json($this->taxRepo->archive($id));
    }
}