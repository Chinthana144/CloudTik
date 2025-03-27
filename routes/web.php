<?php

use App\Http\Controllers\CampController;
use App\Http\Controllers\CampUserController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Models\CampUsers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [CampController::class, 'campPortal'])->middleware('auth', 'verified')->name('camp.campPortal');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/template', function () {
        return view('layouts.template');
    });

    //camps
    Route::get('/camps', [CampController::class, 'index'])->name('camps.index');
    Route::get('/add-camp', [CampController::class, 'create'])->name('camps.create');
    Route::post('/store-camp', [CampController::class, 'store'])->name('camps.store');
    Route::post('/edit-camp', [CampController::class, 'edit'])->name('camps.edit');
    Route::put('/update-camp', [CampController::class, 'update'])->name('camps.update');
    Route::get('gotoCamp/{camp_id}', [CampController::class, 'select'])->name('camp.select');

    //camp users
    Route::get('/campusers', [CampUserController::class, 'index'])->name('campusers.index');
    Route::post('/add-campusers', [CampUserController::class, 'store'])->name('campusers.store');
    Route::get('/getOneCampuser', [CampUserController::class, 'getOneCampuser'])->name('campusers.getOne');
    Route::put('/update-campusers', [CampUserController::class, 'update'])->name('campusers.update');
    Route::delete('/delete-campuser', [CampUserController::class, 'destroy'])->name('campuser.delete');

    Route::get('/home', function () {
        return view('home');
    });

    //customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/add-customers', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store-customers', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('/edit-customers', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/update-customers', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/getCustomers', [CustomerController::class, 'getCustomers']);
    Route::get('/getOneCustomer', [CustomerController::class, 'getOneCustomer']);

    //packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/add-packages', [PackageController::class, 'create'])->name('packages.create');
    Route::post('/store-packages', [PackageController::class, 'store'])->name('packages.store');
    Route::post('/edit-packages', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/update-packages', [PackageController::class, 'update'])->name('packages.update');
    Route::get('/getCustomerPackages', [PackageController::class, 'getCustomerPackages']);

    //counters
    Route::get('/counter', [CounterController::class, 'index'])->name('counter.index');
    Route::post('/add-counter', [CounterController::class, 'store'])->name('counter.store');

    //invoice
    Route::get('/invoice', [SubscriptionController::class, 'index'])->name('invoice.index');
    Route::post('/store-subscription', [SubscriptionController::class, 'store'])->name('subscription.store');

    //receipt print
    Route::get('/receipt-print', [SubscriptionController::class, 'receiptPrint'])->name('invoice.receiptPrint');

    //subscriptions
    Route::get('/view-subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::get('/getOneSubscription', [SubscriptionController::class, 'getOneSubscription'])->name('subscription.getOneSubscription');
    Route::post('/updateSubsStatus', [SubscriptionController::class, 'updateStatus']);
});

//user login
Route::get('/userlogin', function () {
    return view('user-login');
});

require __DIR__ . '/auth.php';
