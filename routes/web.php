<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route publik
Route::get('/', function () { return view('welcome'); });

// Route admin — hanya bisa diakses role:admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Bryant, Theofilus, dll tambahkan route masing-masing di sini
});

// Route penghuni — hanya bisa diakses role:penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->name('penghuni.')->group(function () {
    Route::get('/dashboard', [PenghuniController::class, 'dashboard'])->name('dashboard');
});

require __DIR__.'/auth.php';