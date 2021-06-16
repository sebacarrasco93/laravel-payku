<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Feature;

use SebaCarrasco93\LaravelPayku\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Tests\SimulateResponses;
use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class CanKnowValidOrInvalidResponsesTest extends TestCase
{
    use SimulateResponses;

    public function setUp() : void
    {
        parent::setUp();

        $this->fillAllKeys();

        $this->laravelPayku = new LaravelPayku();
    }

    /** @test */
    function it_knows_when_it_has_an_valid_api_response() {
        $response = $this->successResponse();

        $this->laravelPayku->handleAPIResponse($response);
        $this->assertTrue($this->laravelPayku->hasValidResponse);
    }
}
