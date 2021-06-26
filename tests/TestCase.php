<?php

namespace SebaCarrasco93\LaravelPayku\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebaCarrasco93\LaravelPayKu\LaravelPayKu as LaravelPayKuClass;
use SebaCarrasco93\LaravelPayku\LaravelPaykuServiceProvider;
use SebaCarrasco93\LaravelPayku\RouteServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
    }

    public function fillApiKeys()
    {
        config(['laravel-payku.public_token' => 'somepublictoken']);
        config(['laravel-payku.private_token' => 'someprivatetoken']);
        // config(['laravel-payku.base_url' => 'somebaseurlvalue']);
    }

    public function unfillApiKeys()
    {
        config(['laravel-payku.public_token' => null]);
        config(['laravel-payku.private_token' => null]);
        // config(['laravel-payku.base_url' => null]);
    }

    protected function getEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.conection.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPaykuServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelPayKu' => '\SebaCarrasco93\LaravelPayku\Facades\LaravelPayku::class'
        ];
    }

    
    public function nowIs($datetime)
    {
        \Carbon\Carbon::setTestNow($datetime);
    }
}
