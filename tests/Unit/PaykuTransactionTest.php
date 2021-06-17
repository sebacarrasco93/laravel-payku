<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Unit;

use SebaCarrasco93\LaravelPayku\Tests\TestCase;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaykuTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_see_their_id() {
        $transaction = PaykuTransaction::create(['id' => 'trx...']);

        $this->assertEquals('trx...', $transaction->id);
    }

    /** @test */
    function it_can_get_only_transactions_with_status_register() {
        $transaction = PaykuTransaction::create(['id' => 'trx...', 'status' => 'register']);

        $this->assertCount(1, PaykuTransaction::register()->get());
    }

    /** @test */
    function it_can_get_only_transactions_with_status_success() {
        $transaction = PaykuTransaction::create(['id' => 'trx...', 'status' => 'success']);

        $this->assertCount(1, PaykuTransaction::success()->get());
    }

    /** @test */
    function it_can_get_only_transactions_with_status_pending() {
        $transaction = PaykuTransaction::create(['id' => 'trx...', 'status' => 'pending']);

        $this->assertCount(1, PaykuTransaction::pending()->get());
    }
}
