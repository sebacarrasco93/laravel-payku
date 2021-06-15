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

    // /** @test */
    // function it_can_store_an_incomplete_transaction_in_database() {
    //     $transaction = LaravelPayku::completeTransaction('AAA', [
    //         'amount' => 10000,
    //     ]);

    //     dd($transaction);

    //     $this->assertEquals('AAA', $transaction->order_id);
    //     $this->assertEquals(10000, $transaction->amount);
    // }

    // /** @test */
    // function it_can_update_a_transaction_in_database() {
    //     $original_transaction = LaravelPayku::completeTransaction([
    //         'id' => 'AAA',
    //         'amount' => 5000,
    //     ]);

    //     $this->assertNull(PaykuTransaction::first()->status);
    //     $this->assertNull(PaykuTransaction::first()->email);
    //     $this->assertNull(PaykuTransaction::first()->subject);

    //     $updated_transaction = LaravelPayku::completeTransaction([
    //         'status' => 'success',
    //         'id' => 'AAA',
    //         'order_id' => 100,
    //         'email' => 'seba@sextanet.cl',
    //         'subject' => 'Test',
    //         'amount' => 5000,
    //     ]);

    //     $this->assertNotNull(PaykuTransaction::first()->status);
    //     $this->assertNotNull(PaykuTransaction::first()->id);
    //     $this->assertNotNull(PaykuTransaction::first()->order_id);
    //     $this->assertNotNull(PaykuTransaction::first()->email);
    //     $this->assertNotNull(PaykuTransaction::first()->subject);
    //     $this->assertNotNull(PaykuTransaction::first()->amount);
    // }

    // /** @test */
    // function it_can_complete_transaction_in_database() {
    //     LaravelPayku::create(['']);

    //     $original_transaction = LaravelPayku::completeTransaction([
    //         'id' => 'AAA',
    //         'amount' => 5000,
    //     ]);

    //     dd($original_transaction);

    //     $updated_transaction = LaravelPayku::completeTransaction([
    //         'status' => 'success',
    //         'id' => 'AAA',
    //         'order_id' => 100,
    //         'email' => 'seba@sextanet.cl',
    //         'subject' => 'Test',
    //         'amount' => 5000,
    //     ]);

    //     // dd(PaykuPayment::get());

    //     // $this->assertCount(1, PaykuPayment::get());
    // }

    /** @test */
    function it_can_see_an_order() {
        $this->markTestIncomplete();
        $order = LaravelPayku::returnOrder('AAA');
    }
}
