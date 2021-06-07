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
    }

    /** @test */
    function it_can_create_a_transaction() {
        $transaction = PaykuTransaction::create([
            'order_id' => 'AAA',
            'amount' => 1000,
        ]);

        $this->assertEquals('AAA', $transaction->order_id);
    }

    /** @test */
    function it_can_complete_a_transaction() {        
        $original_transaction = PaykuTransaction::create([
            'order_id' => 'AAA',
            'amount' => 1000,
        ]);

        $transaction = new PaykuTransaction();

        $updated_transaction = $transaction->complete('AAA', [
            'status' => 'success',
            'order_id' => 100,
            'subject' => 'Test',
            'email' => 'seba@sextanet.cl',
        ]);

        $this->assertNotNull(PaykuTransaction::first()->status);
        // $this->assertNotNull(PaykuTransaction::first()->id);
        $this->assertNotNull(PaykuTransaction::first()->order_id);
        $this->assertNotNull(PaykuTransaction::first()->email);
        $this->assertNotNull(PaykuTransaction::first()->subject);
        $this->assertNotNull(PaykuTransaction::first()->amount);
    }

    /** @test */
    function it_cant_complete_a_transaction_if_doesnt_exists() {
        $this->expectException(\Exception::class);

        $original_transaction = PaykuTransaction::create([
            'order_id' => 'AAA',
            'amount' => 1000,
        ]);

        $transaction = new PaykuTransaction();

        $transaction->complete('BBB', [
            'invalid' => 'invalid',
        ]);
    }

    /** @test */
    function it_can_be_paid() {
        $transaction = PaykuTransaction::create([
            'order_id' => 'AAA',
            'amount' => 1000,
        ]);

        $payment = PaykuPayment::create([
            'transaction_id' => $transaction->id,
            'start' => date('y'),
            'end' => date('y'),
            'media' => 'Weypay',
            'verification_key' => md5(1),
            'authorization_code' => '1111',
            'currency' => 'CLP',
        ]);

        $this->assertInstanceOf(PaykuPayment::class, $transaction->payment);
    }
}
