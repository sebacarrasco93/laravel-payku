<?php

namespace SebaCarrasco93\LaravelPayku;

use Illuminate\Support\Facades\Facade;

class LaravelPayku extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-payku';
    }
}
