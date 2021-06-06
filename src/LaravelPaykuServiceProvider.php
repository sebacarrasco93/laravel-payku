<?php

namespace SebaCarrasco93\LaravelPayku;

use Illuminate\Support\ServiceProvider;

class LaravelPaykuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // código...
    }

    public function register()
    {
        $this->app->bind('laravel-payku', function() {
            return new LaravelPayku;
        });
    }
}
