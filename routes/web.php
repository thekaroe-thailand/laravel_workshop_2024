<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PayController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::get('/company/index', [CompanyController::class, 'index']);
Route::get('/room', [RoomController::class, 'index']);
Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/pay', [PayController::class, 'index']);