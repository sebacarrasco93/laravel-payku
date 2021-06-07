<?php

namespace SebaCarrasco93\LaravelPayku\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPayku extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-payku';
    }
}
