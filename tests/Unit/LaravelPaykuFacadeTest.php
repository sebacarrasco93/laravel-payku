<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use SebaCarrasco93\LaravelPayku\Facades\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Models\PaykuPayment;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class LaravelPaykuFacadeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $this->fillAllKeys();
    }

    /** @test */
    function it_knows_which_base_url_in_production_environment() {
        config(['app.env' => 'production']);
        $this->assertEquals('https://app.payku.cl/api', LaravelPayku::apiRoute());
    }

    /** @test */
    function it_knows_which_base_url_in_local_and_testing_environment() {
        config(['app.env' => 'local']);
        $this->assertEquals('https://des.payku.cl/api', LaravelPayku::apiRoute());

        config(['app.env' => 'testing']);
        $this->assertEquals('https://des.payku.cl/api', LaravelPayku::apiRoute());
    }

    /** @test */
    function it_can_override_the_base_url() {
        config(['app.env' => 'production']);
        config(['app.base_url' => 'https://des.payku.cl/api']);

        $this->assertEquals('https://des.payku.cl/api', LaravelPayku::apiRoute());
    }

    /** @test */
    function it_knows_only_its_filled_keys() {
        $this->assertEquals([
            'private_token' => 'someprivatetoken',
            'public_token' => 'somepublictoken',
        ], LaravelPayku::findApiKeys());
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
    function it_can_prepare_an_order() {
        $this->assertEquals([
            'email' => 'seba@sextanet.cl',
            'order' => 'AAA',
            'subject' => 'Test',
            'amount' => '1000',
            'payment' => '1',
            'urlreturn' => route('payku.return', 'AAA'),
            'urlnotify' => route('payku.notify', 'AAA'),
        ], LaravelPayku::prepareOrder('AAA', 'Test', 1000, 'seba@sextanet.cl'));
    }
}
