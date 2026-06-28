<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController; // Import Controller kamu
use App\Http\Controllers\Api\KamarController;

// Semua rute di dalam grup ini wajib membawa Bearer Token Sanctum agar aman
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint API Tagihan milik Theo yang akan dipakai oleh Nathan
    Route::get('/tagihan/{id}', [TagihanController::class, 'apiShow']);
    
});

Route::get('/kamar', [KamarController::class, 'index']);