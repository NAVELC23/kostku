<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\JsonResponse;

class KamarController extends Controller
{
    public function index(): JsonResponse
    {
        $kamar = Kamar::with('fasilitas')->get();

        return response()->json([
            'success' => true,
            'data' => $kamar,
        ]);
    }
}