<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Cegah halaman tersimpan di cache browser.
     * Supaya saat tekan tombol Back, browser minta ulang ke server
     * (bukan tampilkan halaman lama dari cache). Jadi kalau session
     * sudah berubah (logout), tidak bisa "kembali" ke halaman lama.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 01 Jan 2014 00:00:00 GMT');
    }
}