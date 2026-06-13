<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col md:flex-row">

            <!-- KIRI hitam -->
        <div class="w-full md:w-1/2 min-h-[40vh] md:min-h-screen bg-gray-900 flex flex-col items-center justify-center p-8 md:p-12 text-center">
            <h1 class="text-white text-5xl md:text-7xl font-bold mb-4 md:mb-6">Kostku.</h1>
            <p class="text-gray-300 text-base md:text-lg max-w-md">Cari kos nyaman dan kelola semuanya dengan mudah, semua ada di Kostku.</p>
        </div>

            <!-- KANAN abu -->
            <div class="w-full md:w-1/2 bg-gray-100 flex items-center justify-center p-6">
                <div class="w-full max-w-md px-6 py-8 bg-white shadow-md rounded-lg">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>