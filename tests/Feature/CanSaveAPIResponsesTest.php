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

        $this->fillApiKeys();

        $this->laravelPayku = new LaravelPayku();
    }

    /** @test */
    function it_can_save_when_it_has_register_status() {
        $this->laravelPayku->saveAPIResponse($this->registerResponse());

        $registerStatusTransaction = PaykuTransaction::first();

        $this->assertNotNull($registerStatusTransaction->id);
        $this->assertNotNull($registerStatusTransaction->status);
        $this->assertNotNull($registerStatusTransaction->url);
    }

    /** @test */
    function it_can_save_when_it_has_register_status_and_passes_to_success_status() {
        $this->laravelPayku->saveAPIResponse($this->registerResponse());
        $registerStatusTransaction = PaykuTransaction::first();

        $this->assertNull($registerStatusTransaction->order);
        $this->assertNull($registerStatusTransaction->email);
        $this->assertNull($registerStatusTransaction->subject);
        $this->assertNull($registerStatusTransaction->amount);

        $this->laravelPayku->saveAPIResponse($this->successResponse());
        $registerStatusTransaction = PaykuTransaction::first();

        $this->assertCount(1, PaykuTransaction::get());

        $this->assertNotNull($registerStatusTransaction->id);
        $this->assertNotNull($registerStatusTransaction->status);
        $this->assertNotNull($registerStatusTransaction->order);
        $this->assertNotNull($registerStatusTransaction->email);
        $this->assertNotNull($registerStatusTransaction->subject);
        $this->assertNotNull($registerStatusTransaction->url);
        $this->assertNotNull($registerStatusTransaction->amount);
    }
}
