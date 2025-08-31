<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome')->name('home');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/register-success', function () {return view('auth.register-success');})->name('register.success');
require __DIR__.'/auth.php';
