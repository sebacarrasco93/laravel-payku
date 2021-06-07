<?php

namespace SebaCarrasco93\LaravelPayku;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'SebaCarrasco93\LaravelPayku\Http\Controllers';

    public function map()
    {
        Route::namespace($this->namespace)
            ->name('payku.')
            ->prefix(config('laravel-payku.route_prefix')) // "payku"
            ->group(__DIR__ . '/../routes/web.php');
    }
}
