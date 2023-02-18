<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ResetPassword;

class UserController extends Controller
{

    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }
    public function store (UserRequest $request)
    {
        $user = $this->userService->createUser($request->all());
        $token = $user->createToken('auth_token')->accessToken;
        return response()->json(["token" => $token]);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = $request->user();
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json(["token" => $token]);
        } else {
            return response()->json('The provided credentials do not match our records.', 401);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

    }
}
