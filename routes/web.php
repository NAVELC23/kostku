<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenghuniController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;

// Rute CRUD Utama Tagihan
Route::resource('admin/tagihan', TagihanController::class)->names([
    'index' => 'admin.tagihan.index',
    'create' => 'admin.tagihan.create',
    'store' => 'admin.tagihan.store',
    'edit' => 'admin.tagihan.edit',
    'update' => 'admin.tagihan.update',
    'destroy' => 'admin.tagihan.destroy',
]);

// Rute Khusus buat tombol Ekspor PDF buatanmu
Route::get('admin/tagihan/export/pdf', [TagihanController::class, 'exportPdf'])->name('admin.tagihan.pdf');

// Route publik
Route::get('/', function () {
    return redirect()->route('login');
});

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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('tagihan', TagihanController::class);
});

// Rute untuk Penghuni melihat tagihan miliknya sendiri
Route::get('penghuni/tagihan', [TagihanController::class, 'indexPenghuni'])->name('penghuni.tagihan.index');

require __DIR__.'/auth.php';
