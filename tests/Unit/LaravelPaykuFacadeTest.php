<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Unit;

use SebaCarrasco93\LaravelPayku\Tests\TestCase;
use SebaCarrasco93\LaravelPayku\Facades\LaravelPayku;

class LaravelPaykuFacadeTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->fillAllKeys();
    }

    /** @test */
    function it_knows_only_its_filled_keys() {
        // config(['laravel-payku.public_token' => null]);

        $this->assertEquals([
            'base_url' => true,
            'private_token' => true,
            'public_token' => true,
        ], LaravelPayku::knowFilledKeys());
    }

    /** @test */
    function it_knows_when_does_has_the_required_keys() {
        $this->assertTrue(LaravelPayku::hasValidConfig());
    }

    /** @test */
    function it_knows_when_does_not_have_the_required_keys() {
        $this->expectException(\Exception::class);

        $this->unfillAllKeys();
        LaravelPayku::hasValidConfig();
    }

    /** @test */
    function it_can_create_an_order() {
        $this->assertEquals([
            'email' => 'seba@sextanet.cl',
            'order' => 'AAA',
            'subject' => 'Test',
            'amount' => '1000',
            'payment' => '1',
            'urlreturn' => route('payku.return', 'AAA'),
            'urlnotify' => route('payku.notify', 'AAA'),
        ], LaravelPayku::createOrder('AAA', 'Test', 1000, 'seba@sextanet.cl'));
    }
}
