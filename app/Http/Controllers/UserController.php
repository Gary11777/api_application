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
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'There are incorrect password or e-mail.',
                'error' => Response::HTTP_UNAUTHORIZED
            ]);
        }
        $token = $user->createToken('auth_token')->accessToken;
        return response([
            "token" => $token
        ]);

    }
}
