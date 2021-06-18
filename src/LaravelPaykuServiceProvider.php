<?php

namespace SebaCarrasco93\LaravelPayku;

use Illuminate\Support\ServiceProvider;

class LaravelPaykuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadMigrationsFrom($this->basePath('database/migrations'));
        
        $this->loadViewsFrom($this->basePath('resources/views'), 'payku');
        
        $this->loadTranslationsFrom($this->basePath('resources/lang'), 'laravel-payku');

        $this->publishes([
            $this->basePath('config/laravel-payku.php') => base_path('config/laravel-payku.php')
        ], 'laravel-payku-config');

        $this->publishes([
            $this->basePath('database/migrations') => database_path('migrations')
        ], 'laravel-payku-migrations');
    }

    public function register()
    {
        $this->app->bind('laravel-payku', function() {
            return new LaravelPayku;
        });

        $this->mergeConfigFrom(
            $this->basePath('config/laravel-payku.php'), 'laravel-payku'
        );
    }

    public function basePath($path = '')
    {
        return __DIR__ . '/../' . $path;
    }
}
