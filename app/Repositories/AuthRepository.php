<?php

namespace App\Repositories;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository {
    public function login($data) {
        try {
            $user = User::with(['role.rolePermissions.permission', 'app'])->where('email', $data['email'])->first();
            if (!$user) return resultFunction("Err code AR-L: user " . $data['email'] . ' is not found');

            if (!Hash::check($data['password'], $user['password'])) {
                return resultFunction("Err code AR-L: password of user " . $data['email'] . ' is not correct');
            }

            $permissions = [];
            foreach ($user->role->rolePermissions as $rolePermission) {
                $permissions[] = $rolePermission->permission->title;
            }

            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;

            return resultFunction("", true, [
                "user" => $user,
                "role" => $user->role->title,
                "permissions" => $permissions,
                "token" => $token,
                "sign_at" => date("Y-m-d H:i:s")
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-L: catch " . $e->getMessage());
        }
    }

    public function logout($request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return resultFunction("Success logged out", true);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-LOg: catch " . $e->getMessage());
        }
    }

    public function backendLogin($data) {
        try {
            $adminUser = AdminUser::with([])->where('email', $data['email'])->first();
            if (!$adminUser) return resultFunction("Err code AR-BL: admin user " . $data['email'] . ' is not found');

            if (!Hash::check($data['password'], $adminUser['password'])) {
                return resultFunction("Err code AR-BL: password of admin user " . $data['email'] . ' is not correct');
            }

            Auth::login($adminUser);
            $token = $adminUser->createToken('API Token')->plainTextToken;

            return resultFunction("", true, [
                "admin_user" => $adminUser,
                "token" => $token,
                "sign_at" => date("Y-m-d H:i:s")
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-BL: catch " . $e->getMessage());
        }
    }

    public function backendLogout($request) {
        try {
            $request->user('admin')->currentAccessToken()->delete();
            return resultFunction("Success logged out", true);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-LOg: catch " . $e->getMessage());
        }
    }
}