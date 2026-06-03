<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenghuniController;
use Illuminate\Support\Facades\Route;

// Route publik
Route::get('/', function () { return view('welcome'); });
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route admin — hanya bisa diakses role:admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Bryant, Theofilus, dll tambahkan route masing-masing di sini
    Route::resource('kamar', KamarController::class);
    Route::resource('penghuni', PenghuniController::class);
});

// Route penghuni — hanya bisa diakses role:penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->name('penghuni.')->group(function () {
    Route::get('/dashboard', [PenghuniController::class, 'dashboard'])->name('dashboard');
});

require __DIR__.'/auth.php';
