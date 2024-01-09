<?php

namespace App\Http\Controllers\Api\InputData;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller {
    protected $salesRepo;

    public function __construct()
    {
        $this->salesRepo = new SalesRepository();
    }

    public function store(Request $request) {
        return response()->json($this->salesRepo->store($request, $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only(['status']);
        $sales = Sales::with(['sales_products', 'sales_attachments', 'contact', 'sales_payments']);

        if (!empty($filters['status'])) {
            $dateNow = date("Y-m-d");
            if ($filters['status'] === 'Overdue') {
                $sales = $sales->where('due_date', '<', $dateNow);
            } else {
                if ($filters['status'] === 'Open') {
                    $sales = $sales->where('payment_amount_total', 0);
                } else if ($filters['status'] === 'Paid') {
                    $sales = $sales->whereRaw('payment_amount_total = grand_total');
                } else {
                    $sales = $sales->where('payment_amount_total', '>', 0)->whereRaw('payment_amount_total != grand_total');
                }
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

    public function detailPayment($id) {
        return response()->json($this->salesRepo->detailPayment($id));
    }

    public function deletePayment($id, $salesId) {
        return response()->json($this->salesRepo->deletePayment($id, $salesId));
    }

    public function summarizeCount(Request $request) {
        return response()->json($this->salesRepo->summarizeCount($request->header('company_id')));
    }

    public function approvePayment($id) {
        return response()->json($this->salesRepo->approvePayment($id));
    }

    public function delete($id) {
        return response()->json($this->salesRepo->delete($id));
    }
}