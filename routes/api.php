<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;

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

// I changed from 'auth:sanctum' to 'auth:api' or 'api'.
Route::middleware('api')->post('/users', function (UserRequest $request) {
    return $request->user();
});

Route::post('/users', [UserController::class,'store']);
