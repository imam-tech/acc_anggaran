<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;

class AccountingRepository {
    public function changeRole($data) {
        try {
            $validator = \Validator::make($data, [
                "role_id" => "required",
                "user_id" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code AR-St: " . collect($validator->errors()->all())->implode(" , "));

            $user = User::find($data['user_id']);
            if (!$user) return resultFunction("Err code AR-St: Email not found for ID " . $data['user_id']);

            $role = Role::find($data['role_id']);
            if (!$role) return resultFunction("Err code AR-St: Role not found for ID " . $data['role_id']);

            $user->role_id = $role->id;
            $user->save();

            return resultFunction("Updating role for user successfully", true, $user);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-St: catch " . $e->getMessage());
        }
    }
}