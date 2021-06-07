<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Unit;

use SebaCarrasco93\LaravelPayku\Tests\TestCase;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaravelPaykuDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }

    /** @test */
    function can_interact_with_models_and_database() {
        $payku = new PaykuTransaction();

        $payku->order_id = 'AAA';
        $payku->save();

        $this->assertEquals('AAA', PaykuTransaction::first()->order_id);
    }
}
