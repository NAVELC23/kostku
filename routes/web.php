<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route publik
Route::get('/', function () {
    return view('welcome');
});
Route::get('/kamar', [KamarController::class, 'publik'])->name('kamar.publik');
// Profile (semua user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route admin — hanya role:admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route export PDF HARUS sebelum resource, biar tidak ketabrak {tagihan}
    Route::get('tagihan/export/pdf', [TagihanController::class, 'exportPdf'])->name('tagihan.pdf');

    Route::resource('kamar', KamarController::class);
    Route::resource('penghuni', PenghuniController::class);
    Route::resource('tagihan', TagihanController::class);
});

// Route penghuni — hanya role:penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->name('penghuni.')->group(function () {
    Route::get('/dashboard', [PenghuniController::class, 'dashboard'])->name('dashboard');
    Route::get('/tagihan', [TagihanController::class, 'indexPenghuni'])->name('tagihan.index');
});

require __DIR__.'/auth.php';