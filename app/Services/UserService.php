<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data)
    {
        $user_data['name'] = $data['name'];
        $user_data['email'] = $data['email'];
        $user_data['password'] = Hash::make($data['password']);
        return User::create($user_data);
    }
}
