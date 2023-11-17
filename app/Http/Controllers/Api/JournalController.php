<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Repositories\JournalRepository;
use Illuminate\Http\Request;

class JournalController extends Controller {
    protected $journalRepo;

    public function __construct()
    {
        $this->journalRepo = new JournalRepository();
    }

    public function index(Request $request) {
        $journals = Journal::with(['journalItems']);
        $journals = $journals->orderBy('id', 'desc')->get();
        return response()->json($journals);
    }

    public function detail($id) {
        return response()->json($this->journalRepo->detail($id));
    }

    public function approval($id, Request $request) {
        return response()->json($this->journalRepo->approval($id, $request->all()));
    }
}