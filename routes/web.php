<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboardController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});

Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::resource('users', UserController::class);
