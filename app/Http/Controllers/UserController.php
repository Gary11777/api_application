<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store (UserRequest $request)
    {
        $user_data['name'] = $request->name;
        $user_data['email'] = $request->email;
        $user_data['password'] = Hash::make($request->password);
        $user = User::create($user_data);
        $token = $user->createToken('Token Name')->accessToken;
        return ["token" => $token];
    }
}
