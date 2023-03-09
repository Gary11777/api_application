<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::put('/users/{user}', [UserController::class, 'updateUser']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{user}', [UserController::class, 'delete']);
});
Route::post('/users', [UserController::class,'store']);
Route::post('/login', [UserController::class,'login']);
Route::post('/reset_password', [UserController::class,'resetPassword']);
Route::post('/set_newpassword', [UserController::class,'setNewPassword']);
