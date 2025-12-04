<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Client;
use App\Http\Middleware\Manager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/admin/users', UserController::class)->middleware(Admin::class);
Route::post('/admin/users/{id}',[UserController::class, 'maj'])->middleware('auth')->name('users.maj');
Route::resource('/transactions', TransactionController::class)->middleware(Client::class);
Route::resource('/contacts',ContactController::class)->middleware(Client::class);
Route::get('/iban/{id}',[ContactController::class, 'iban'])->middleware(Client::class)->name('contacts.iban');

require __DIR__.'/auth.php';
