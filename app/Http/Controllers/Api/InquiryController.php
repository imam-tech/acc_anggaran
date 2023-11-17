<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Repositories\InquiryRepository;
use Illuminate\Http\Request;

class InquiryController extends Controller {
    protected $inquiryRepo;

    public function __construct()
    {
        $this->inquiryRepo = new InquiryRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['bank']);
        $inquiries = Inquiry::with([]);

        if (!empty($filters['bank'])) {
            $inquiries = $inquiries->where('bank', $filters['bank']);
        }
        $inquiries = $inquiries->orderBy('id', 'desc')->get();
        return response()->json($inquiries);
    }

    public function store(Request $request) {
        return response()->json($this->inquiryRepo->store($request->all()));
    }
}