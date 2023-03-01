<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\updateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\NewPasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ResetPassword;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }
    public function store(UserRequest $request)
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
        $this->userService->resetPassword($request->all());
        return response()->json(['result' => true, 'message' => 'Please check your e-mail to reset your password.']);
    }

    public function setNewPassword(NewPasswordRequest $request)
    {
        $this->userService->setNewPassword($request->all());
        return response()->json(['result' => true, 'message' => 'Password is updated!']);
    }

    /**
     * Update the given post.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateUser(updateUserRequest $request, User $user)
    {
        $this->userService->updateUser($request->all(), $user);
    }
}
