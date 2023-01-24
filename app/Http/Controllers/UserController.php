<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function store (UserRequest $request)
    {
        $user_data['name'] = $request->name;
        $user_data['email'] = $request->email;
        $user_data['password'] = Hash::make($request->password);
        $this->userService->createUser($user_data);
    }
}
