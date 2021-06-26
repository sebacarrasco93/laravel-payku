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

    /** @test */
    function it_knows_when_it_was_marked_as_notified() {
        $transaction = PaykuTransaction::create(['id' => 'trx...', 'notified_at' => null]);

        $transaction->markAsNotified();

        $this->assertNotNull($transaction->notified_at);
    }

    /** @test */
    function it_can_notify_for_first_time() {
        $transaction = PaykuTransaction::create(['id' => 'trx...', 'notified_at' => null]);

        $this->nowIs('2021-07-26');

        $now = now();

        $transaction->notifyForFirstTime();

        $this->assertEquals($now->format('Y-m-d'), $transaction->notified_at->format('Y-m-d'));

        $transaction->notifyForFirstTime();

        $this->nowIs('2021-07-30');

        $this->assertNotEquals('2021-07-30', $transaction->notified_at->format('Y-m-d'));
    }
}
