<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::apiResource('users', UserController::class);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('users/{id}', [UserController::class, 'update']);
    Route::delete('user/{user}', [UserController::class, 'destroy']);