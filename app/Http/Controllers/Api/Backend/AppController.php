<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Repositories\AppRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class AppController extends Controller {
    protected $appRepo;

    public function __construct()
    {
        $this->appRepo = new AppRepository();
    }

    public function index() {
        $apps = App::with(['users']);

        $apps = $apps->orderBy('id', 'desc')->paginate(25);
        return response()->json($apps);
    }

    public function store(Request $request) {
        return response()->json($this->appRepo->store($request->all()));
    }

    public function detail($id = null) {
        return response()->json($this->appRepo->detail($id));
    }
}