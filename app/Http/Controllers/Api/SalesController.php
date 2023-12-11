<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller {
    protected $salesRepo;

    public function __construct()
    {
        $this->salesRepo = new SalesRepository();
    }

    public function storeCustomer(Request $request) {
        return response()->json($this->salesRepo->storeCustomer($request->all(), $request->header('company_id')));
    }

    public function indexCustomer(Request $request) {
        $filters = $request->only([]);
        $customers = Customer::with([]);

        $customers = $customers->where('company_id', $request->header('company_id'));
        $customers = $customers->get();
        return response()->json($customers);
    }

    public function detailCustomer($id) {
        return response()->json($this->salesRepo->detailCustomer($id));
    }

    public function store(Request $request) {
        return response()->json($this->salesRepo->store($request->all(), $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only([]);
        $sales = Customer::with([]);

        $sales = $sales->where('company_id', $request->header('company_id'));
        $sales = $sales->get();
        return response()->json($sales);
    }
}