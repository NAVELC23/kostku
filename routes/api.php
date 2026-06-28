<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\Api\KamarController;

// Publik
Route::get('/kamar', [KamarController::class, 'index']);

// Tagihan penghuni
Route::get('/tagihan/penghuni', [TagihanController::class, 'apiPenghuni']);

// Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tagihan/{id}', [TagihanController::class, 'apiShow']);
});