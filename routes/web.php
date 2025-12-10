<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController; // Tambahkan ini

Route::get('/dashboard-pkl', [App\Http\Controllers\Dashboard_Controller::class, 'index'])->name('dashboard.pkl');
Route::get('/cetak-surat-penjajakan', [App\Http\Controllers\Dashboard_Controller::class, 'cetakPenjajakan'])->name('cetak.surat.penjajakan');
Route::post('/cetak-surat-penjajakan', [App\Http\Controllers\Dashboard_Controller::class, 'prosesCetakPenjajakan'])->name('proses.cetak.penjajakan');
Route::get('/cetak-surat-penempatan', [App\Http\Controllers\Dashboard_Controller::class, 'cetakPenempatan'])->name('cetak.surat.penempatan');
Route::post('/cetak-surat-penempatan', [App\Http\Controllers\Dashboard_Controller::class, 'prosesCetakPenempatan'])->name('proses.cetak.penempatan');

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
