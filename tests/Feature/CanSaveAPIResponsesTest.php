<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use SebaCarrasco93\LaravelPayku\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Tests\SimulateResponses;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class CanSaveAPIResponsesTest extends TestCase
{
    use RefreshDatabase;
    use SimulateResponses;

    public function setUp() : void
    {
        parent::setUp();

        $this->fillAllKeys();

        $this->laravelPayku = new LaravelPayku();
    }

    /** @test */
    function it_can_save_when_it_has_register_status() {
        $response = $this->registerResponse();

        $this->laravelPayku->saveAPIResponse($response);

        $transaction = PaykuTransaction::first();
        $this->assertEquals('trx...', $transaction->id);
    }
}
