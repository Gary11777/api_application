<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\SetNewPassword;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(array $data)
    {
        $user_data['name'] = $data['name'];
        $user_data['email'] = $data['email'];
        $user_data['password'] = Hash::make($data['password']);
        return User::create($user_data);
    }

    public function resetPassword(array $data, string $token)
    {
        $userID = DB::table('users')->where('email', $data['email'])->value('id');
        if ($userID != null) {
            ResetPassword::updateOrCreate(
                ['user_id' => $userID],
                [
                    'user_id' => $userID,
                    'token' => $token
                ]
            );
        } else {
            return response()->json(['User not found!', 404]);
        }
    }
    public function setNewPassword(array $data)
    {
        $token = $data['token'];
        $password = Hash::make($data['password']);
        $userID = DB::table('reset_passwords')->where('token', $token)->value('user_id');
        if ($userID != null) {
            SetNewPassword::updateOrCreate(
                ['id' => $userID],
                [
                    'password' => $password
                ]
            );
        } else {
            return response()->json(['User not found!', 404]);
        }
    }
}
