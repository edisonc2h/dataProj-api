<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profiles', [ProfileController::class, 'profiles']);
    Route::post('profile', [ProfileController::class, 'save']);
    Route::get('profile/{id}', [ProfileController::class, 'get']);
    Route::put('profile/{id}', [ProfileController::class, 'update']);
    Route::delete('profile/{id}', [ProfileController::class, 'delete']);

    Route::get('users', [UserController::class, 'users']);
    Route::post('user', [UserController::class, 'save']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::get('user/{id}', [UserController::class, 'get']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    Route::patch('changeUserPassword/{id}', [UserController::class, 'changeUserPassword']);
});
