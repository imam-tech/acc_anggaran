<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    protected $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['name', 'email', 'role']);
        $user = User::with(['role.rolePermissions.permission']);

        if (!empty($filters['name'])) {
            $user = $user->where('name', 'LIKE', "%" . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $user = $user->where('email', 'LIKE', "%" . $filters['email'] . '%');
        }

        if (!empty($filters['role'])) {
            $user = $user->whereHas('role', function ($q) use ($filters) {
                $q->where('title', $filters['role']);
            });
        }

        $user = $user->orderBy('id', 'desc')->where('app_id', Auth::user()->app_id)->get();
        return response()->json($user);
    }

    public function store(Request $request) {
        return response()->json($this->userRepo->store($request->all()));
    }

    public function delete($id = null) {
        return response()->json($this->userRepo->delete($id));
    }

    public function notStaff() {
        $user = User::with(['role']);

        $user = $user->where('role_id', "<>", 6);
        $user = $user->orderBy('id', 'desc')->get();
        return response()->json($user);
    }

    public function changePassword(Request $request) {
        return response()->json($this->userRepo->changePassword($request->all()));
    }
}