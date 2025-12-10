<?php

use Illuminate\Support\Facades\Route;


    Route::get('/dashboard-pkl', [App\Http\Controllers\Dashboard_Controller::class, 'index'])->name('dashboard.pkl');

    Route::get('/cetak-surat-penjajakan', [App\Http\Controllers\Dashboard_Controller::class, 'cetakPenjajakan'])->name('cetak.surat.penjajakan');
    Route::post('/cetak-surat-penjajakan', [App\Http\Controllers\Dashboard_Controller::class, 'prosesCetakPenjajakan'])->name('proses.cetak.penjajakan');

    Route::get('/cetak-surat-penempatan', [App\Http\Controllers\Dashboard_Controller::class, 'cetakPenempatan'])->name('cetak.surat.penempatan');
    Route::post('/cetak-surat-penempatan', [App\Http\Controllers\Dashboard_Controller::class, 'prosesCetakPenempatan'])->name('proses.cetak.penempatan');


    


