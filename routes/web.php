<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\FasilitasController;

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
    Route::get('fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::post('fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
    Route::resource('penghuni', PenghuniController::class);
    Route::resource('tagihan', TagihanController::class);

    Route::get('perbaikan', [PerbaikanController::class, 'index'])->name('perbaikan.index');
    Route::get('perbaikan/{id}/edit', [PerbaikanController::class, 'edit'])->name('perbaikan.edit');
    Route::put('perbaikan/{id}', [PerbaikanController::class, 'update'])->name('perbaikan.update');
    Route::delete('perbaikan/{id}', [PerbaikanController::class, 'destroy'])->name('perbaikan.destroy');
});

// Route penghuni — hanya role:penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->name('penghuni.')->group(function () {
    Route::get('/dashboard', [PenghuniController::class, 'dashboard'])->name('dashboard');
    Route::get('/tagihan', [TagihanController::class, 'indexPenghuni'])->name('tagihan.index');

    Route::get('perbaikan', [PerbaikanController::class, 'indexPenghuni'])->name('perbaikan.index');
    Route::get('perbaikan/create', [PerbaikanController::class, 'create'])->name('perbaikan.create');
    Route::post('perbaikan', [PerbaikanController::class, 'store'])->name('perbaikan.store');
    Route::delete('perbaikan/{id}', [PerbaikanController::class, 'destroyPenghuni'])->name('perbaikan.destroy');
});

// Rute untuk download Excel buatan Theo
Route::get('/tagihan/export-excel', [TagihanController::class, 'exportExcel'])->name('admin.tagihan.excel');

require __DIR__.'/auth.php';