<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use SebaCarrasco93\LaravelPayku\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Models\PaykuPayment;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Tests\SimulateResponses;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class WorkWithValidOrInvalidResponsesTest extends TestCase
{
    use SimulateResponses;
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $this->fillApiKeys();

        $this->laravelPayku = new LaravelPayku();
    }

    /** @test */
    function it_knows_when_it_has_an_valid_api_response() {
        $response = $this->successResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertTrue($this->laravelPayku->hasValidResponse);
    }

    /** @test */
    function it_knows_when_it_does_not_have_an_valid_api_response() {
        $this->expectException(\Exception::class);

        $response = $this->invalidResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertFalse($this->laravelPayku->hasValidResponse);
    }

    /** @test */
    function it_can_create_the_pending_response_in_transactions() {
        $response = $this->pendingResponse();
        
        $this->laravelPayku->saveAPIResponse($response);

        $this->assertCount(1, PaykuTransaction::get());
        $this->assertCount(0, PaykuPayment::get());
    }

    /** @test */
    function it_cannot_create_the_failed_response_in_transactions() {
        $this->expectException(\Exception::class);
        
        $response = $this->failedResponse();
        
        $this->laravelPayku->saveAPIResponse($response);

        $this->assertCount(0, PaykuTransaction::get());
        $this->assertCount(0, PaykuPayment::get());
    }

    /** @test */
    function it_can_create_the_register_response_in_transactions() {
        $response = $this->registerResponse();
        
        $this->laravelPayku->saveAPIResponse($response);

        $this->assertCount(1, PaykuTransaction::get());
        $this->assertCount(0, PaykuPayment::get());
    }

    /** @test */
    function it_can_create_the_success_response_in_transactions() {
        $response = $this->successResponse();
        
        $this->laravelPayku->saveAPIResponse($response);

        $this->assertCount(1, PaykuTransaction::get());
        $this->assertCount(1, PaykuPayment::get());
    }
}
