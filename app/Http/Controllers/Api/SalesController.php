<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller {
    protected $salesRepo;

    public function __construct()
    {
        $this->salesRepo = new SalesRepository();
    }

    public function storeCustomer(Request $request) {
        return response()->json($this->salesRepo->storeCustomer($request, $request->header('company_id')));
    }

    public function indexCustomer(Request $request) {
        $filters = $request->only([]);
        $customers = Customer::with([]);

        $customers = $customers->where('company_id', $request->header('company_id'));
        $customers = $customers->orderByDesc('id')->get();
        return response()->json($customers);
    }

    public function detailCustomer($id) {
        return response()->json($this->salesRepo->detailCustomer($id));
    }

    public function store(Request $request) {
        return response()->json($this->salesRepo->store($request, $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only(['status']);
        $sales = Sales::with(['sales_products', 'sales_attachments', 'customer']);

        if (!empty($filters['status'])) {
            $dateNow = date("Y-m-d");
            if ($filters['status'] === 'Paid') {
                $sales = $sales->whereNotNull('paid_date');
            } else if ($filters['status'] === 'Open') {
                $sales = $sales->where('due_date', '>', $dateNow)->whereNull('paid_date');
            } else if ($filters['status'] === 'Overdue') {
                $sales = $sales->where('due_date', '<', $dateNow)->whereNull('paid_date');
            }
        }

        $sales = $sales->where('company_id', $request->header('company_id'));
        $sales = $sales->orderByDesc('id')->paginate(25);
        return response()->json($sales);
    }

    public function detail($id) {
        return response()->json($this->salesRepo->detail($id));
    }

    public function storePayment(Request $request) {
        return response()->json($this->salesRepo->storePayment($request));
    }
}