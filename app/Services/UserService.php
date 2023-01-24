<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $user_data)
    {
        $user = User::create($user_data);
        $token = $user->createToken('Token Name')->accessToken;
        return ["token" => $token];
    }
}
