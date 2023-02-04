<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        return response([
            "token" => $token
        ]);
    }

    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;
            return response([
                "token" => $token
            ]);
        } else {
            return back()->withErrors([
                'message' => 'The provided credentials do not match our records.'
            ]);
        }
    }
}
