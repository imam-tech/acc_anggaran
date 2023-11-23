<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    public function store($data) {
        try {

            if ($data['id']) {
                $validator = \Validator::make($data, [
                    "name" => "required",
                    "email" => "required",
                ]);
            } else {
                $validator = \Validator::make($data, [
                    "name" => "required",
                    "email" => "required",
                    "password" => "required",
                    "password_confirmation" => "required",
                ]);
            }

            if ($validator->fails()) return resultFunction("Err code UR-St: " . collect($validator->errors()->all())->implode(" , "));

                if ($data['id']) {
                $user = User::find($data['id']);
                if (!$user) return resultFunction("Err code UR-St: user not found for ID " . $data['id']);
            } else {
                $userHistory = User::where('email', $data['email'])->first();
                if ($userHistory) return resultFunction("Err code UR-St: user is already exist for email " . $data['email']);

                if ($data['password'] !== $data['password_confirmation'])  return resultFunction("Err code UR-St: password and password confirmation is not same");
                $user = new User();
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            $message = $data['id'] ? "Updating User successfully" : "Creating User successfully";
            return resultFunction($message, true, $user);
        } catch (\Exception $e) {
            return resultFunction("Err code UR-St: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $user = User::find($id);
            if (!$user) return resultFunction("Err code PR-Dl: user not found for ID " .$id);

            $user->delete();

            return resultFunction("Deleting Tax successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }
    public function changePassword($data) {
        try {
            $validator = \Validator::make($data, [
                "id" => "required",
                "password" => "required",
                "password_confirmation" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code UR-CP: " . collect($validator->errors()->all())->implode(" , "));

            $user = User::find($data['id']);
            if (!$user) return resultFunction("Err code UR-CP: user not found for ID " . $data['id']);

            $user->password = Hash::make($data['password']);
            $user->save();

            return resultFunction("Change Password User successfully", true, $user);
        } catch (\Exception $e) {
            return resultFunction("Err code UR-CP: catch " . $e->getMessage());
        }
    }
}