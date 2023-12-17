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

    public function store(Request $request) {
        return response()->json($this->purchaseRepo->store($request, $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only(['status']);
        $purchases = Purchase::with(['purchase_products', 'purchase_attachments', 'supplier']);

        if (!empty($filters['status'])) {
            $dateNow = date("Y-m-d");
            if ($filters['status'] === 'Paid') {
                $purchases = $purchases->whereNotNull('paid_date');
            } else if ($filters['status'] === 'Open') {
                $purchases = $purchases->where('due_date', '>', $dateNow)->whereNull('paid_date');
            } else if ($filters['status'] === 'Overdue') {
                $purchases = $purchases->where('due_date', '<', $dateNow)->whereNull('paid_date');
            }
        }

        $purchases = $purchases->where('company_id', $request->header('company_id'));
        $purchases = $purchases->orderBy('id', 'desc')->paginate(25);
        return response()->json($purchases);
    }

    public function detail($id) {
        return response()->json($this->purchaseRepo->detail($id));
    }
}