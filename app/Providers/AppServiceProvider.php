<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Perbaikan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.navigation', 'layouts.navigation-admin'], function ($view) {
            $view->with('jumlahMenunggu', Perbaikan::where('status', 'Menunggu')->count());
        });
    }
}