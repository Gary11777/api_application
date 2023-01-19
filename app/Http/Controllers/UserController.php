<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function store (UserRequest $request)
    {
        // $user = User::find(1);
        $user = User::create($request->only('name', 'email', 'password'));
        $token = $user->createToken('Token Name')->accessToken;
        return ["token" => $token];
        // return ["status 201", ["token" => $token]];
    }
}
