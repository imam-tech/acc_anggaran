<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authRepo;

    public function __construct()
    {
        $this->authRepo = new AuthRepository();
    }

    public function login(Request $request)
    {
        return response()->json($this->authRepo->login($request->all()));
    }

    public function logout(Request $request)
    {
        return response()->json($this->authRepo->logout($request));
    }

    public function backendLogin(Request $request)
    {
        return response()->json($this->authRepo->backendLogin($request->all()));
    }

    public function backendLogout(Request $request)
    {
        return response()->json($this->authRepo->backendLogout($request));
    }
}
