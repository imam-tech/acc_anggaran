<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller {
    protected $contactRepo;

    public function __construct()
    {
        $this->contactRepo = new ContactRepository();
    }

    public function store(Request $request) {
        return response()->json($this->contactRepo->store($request->all(), $request->header('company_id')));
    }

    public function index(Request $request) {
        $filters = $request->only(['type', 'is_archive']);
        $contacts = Contact::with(['sales', 'purchases']);

        if (!empty($filters['type'])) {
            if ($filters['type'] === 'customer') {
                $contacts =  $contacts->whereNotNull('sale_account_id');
            } else if ($filters['type'] === 'vendor') {
                $contacts =  $contacts->whereNotNull('purchase_account_id');
            }
        }

        if (!empty($filters['is_archive'])) {
            $contacts = $contacts->where('is_archive', $filters['is_archive'] === 'yes' ? 1 : 0);
        }
        $contacts = $contacts->where('company_id', $request->header('company_id'));
        $contacts = $contacts->orderByDesc('id')->get();
        return response()->json($contacts);
    }

    public function detail($id) {
        return response()->json($this->contactRepo->detail($id));
    }

    public function archive($id) {
        return response()->json($this->contactRepo->archive($id));
    }
}