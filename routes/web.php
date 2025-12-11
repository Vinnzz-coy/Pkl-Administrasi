<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController; // Tambahkan ini

Route::get('/dashboard-pkl', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.pkl');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
