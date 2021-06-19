<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Feature;

use SebaCarrasco93\LaravelPayku\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Tests\SimulateResponses;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class CanHandleAPIResponsesTest extends TestCase
{
    use SimulateResponses;

    public function setUp() : void
    {
        parent::setUp();

        $this->fillApiKeys();

        $this->laravelPayku = new LaravelPayku();
    }

    /** @test */
    function it_can_handle_when_it_has_register_status() {
        $response = $this->registerResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertEquals('register', $this->laravelPayku->status);
    }

    /** @test */
    function it_can_handle_when_it_has_pending_status() {
        $response = $this->pendingResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertEquals('pending', $this->laravelPayku->status);
    }

    /** @test */
    function it_can_handle_when_it_has_failed_status() {
        $response = $this->failedResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertEquals('failed', $this->laravelPayku->status);
    }

    /** @test */
    function it_can_handle_when_it_has_success_status() {
        $response = $this->successResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertEquals('success', $this->laravelPayku->status);
    }

    /** @test */
    function it_can_handle_an_error_when_it_has_an_invalid_status() {
        $this->expectException(\Exception::class);
        $response = $this->invalidResponse();

        $this->laravelPayku->handleAPIResponse($response);
    }
}
