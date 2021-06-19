<?php

namespace SebaCarrasco93\LaravelPayku\Tests\Feature;

use SebaCarrasco93\LaravelPayku\Tests\TestCase;

class CanGetRoutesTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->fillApiKeys();
    }

    /** @test */
    function it_can_create_an_order() {
        $this->markTestIncomplete();
        $this->withoutExceptionHanpdling();

        $order = [
            'email' => 'seba@sextanet.cl',
            'order' => 'AAA',
            'subject' => 'Test',
            'amount' => '1000',
            'payment' => '1',
            'urlreturn' => route('payku.return', 'AAA'),
            'urlnotify' => route('payku.notify', 'AAA'),
        ];

        $this->post(route('payku.create', $order))->getContent();

        $this->post(route('payku.create', $order))->assertSuccessful();
    }
}
