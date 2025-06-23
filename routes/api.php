<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WifiLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    //customer routes
    Route::post('/register_customer', [CustomerController::class, 'customerRegister'])->name('api.register.customer');
    Route::get('/search_customer', [CustomerController::class, 'searchCustomers'])->name('api.search.customer');

    //packages
    Route::get('/getCustomerPackages', [PackageController::class, 'getCustomerPackages'])->name('api.customerPackages');

    // Add your authenticated routes here
    Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');
});

// API route for user login
Route::post('/login', [UserController::class, 'login'])->name('api.login');
