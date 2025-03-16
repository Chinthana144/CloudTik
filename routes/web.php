<?php

use App\Http\Controllers\CampController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__ . '/auth.php';
