<?php

namespace SebaCarrasco93\LaravelPayKu\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
// use SebaCarrasco93\LaravelPayKu\Facades\LaravelPayKu;
use SebaCarrasco93\LaravelPayKu\LaravelPayKu as LaravelPayKuClass;
use SebaCarrasco93\LaravelPayKu\LaravelPaykuServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        
        // ...
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPaykuServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelPayKu' => '\SebaCarrasco93\LaravelPayKu\Facades\LaravelPayKu::class'
        ];
    }
}
