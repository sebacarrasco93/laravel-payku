<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use SebaCarrasco93\LaravelPayku\Models\PaykuPayment;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class LaravelPaykuDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $this->transaction = new PaykuTransaction();
    }

    /** @test */
    function it_can_init_an_incomplete_transaction_by_creating_with_few_data() {
        $incomplete = $this->transaction->init('1', 1000);

        $this->assertEquals('1', PaykuTransaction::first()->id);
        $this->assertEquals(1000, PaykuTransaction::first()->amount);
    }

    /** @test */
    function it_can_complete_a_transaction() {        
        $this->transaction->init('1', 1000);

        $updated_transaction = $this->transaction->complete('1', [
            'status' => 'success',
            'order_id' => 100,
            'subject' => 'Test',
            'email' => 'seba@sextanet.cl',
        ]);

        $transaction = PaykuTransaction::first();

        $this->assertEquals(1, $transaction->id);
        $this->assertEquals('success', $transaction->status);
        $this->assertEquals('100', $transaction->order_id);
        $this->assertEquals('seba@sextanet.cl', $transaction->email);
        $this->assertEquals('Test', $transaction->subject);
        $this->assertEquals(1000, $transaction->amount);
    }

    /** @test */
    function it_cant_complete_a_transaction_if_doesnt_exists() {
        $this->expectException(\Exception::class);

        $this->transaction->init('1', 1000);

        $this->transaction->complete('BBB', [
            'invalid' => 'invalid',
        ]);
    }

    /** @test */
    function it_can_be_marked_as_paid() {
        $this->transaction->init('1', 1000);
        
        $this->transaction->markAsPaid('1', [
            'start' => date('y'),
            'end' => date('y'),
            'media' => 1, // Webpay
            'verification_key' => md5(microtime()),
            'authorization_code' => md5(microtime()),
            'currency' => 'CLP',
        ]);

        $transaction = PaykuTransaction::first();

        $this->assertInstanceOf(PaykuPayment::class, $transaction->payment);
    }
}