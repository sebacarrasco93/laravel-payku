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
}
