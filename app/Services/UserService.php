<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $user_data)
    {
        return User::create($user_data);
    }
}
