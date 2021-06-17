<?php

namespace SebaCarrasco93\LaravelPayku\Tests;

trait SimulateResponses
{
    public function registerResponse()
    {
        $response = [
            'status' => 'register',
            'id' => 'trx...',
            'url' => 'https://des.payku.cl/gateway/cobro?id=trx3adbf8e836510de62&valid=4e31d8c7c9',
        ];

        return collect($response);
    }

    public function pendingResponse()
    {
        $response = [
            'status' => 'pending',
            'id' => 'trx...',
            'created_at' => now(),
            'order' => 1,
            'email' => 'example@domain.com',
            'subject' => 'Pending transaction',
            'amount' => '1000',
            'payment' => collect([]),
            'gateway_response' => collect([
                'status' => 'pending',
                'message' => 'waiting response',
            ]),
        ];

        return collect($response);
    }

    public function failedResponse()
    {
        $response = [
            'status' => 'failed',
            'type' => 'Unprocessable Entity',
            'message_error' => collect([
                'order' => 'invalid, max [20] characters',
            ]),
        ];

        return collect($response);
    }

    public function successResponse()
    {
        $response = [
            'status' => 'success',
            'id' => 'trx...',
            'created_at' => now(),
            'order' => 1,
            'email' => 'example@domain.com',
            'subject' => 'Successful transaction',
            'amount' => '1000',
            'payment' => collect([
                'start' => now(),
                'end' => now()->addMinute(),
                'media' => 'Webpay',
                'transaction_id' => 'trx...',
                'authorization_code' => '1213',
                'verification_key' => '12345abcdef...',
                'last_4_digits' => '6623',
                'installments' => 0,
                'card_type' => 'VN',
                'additional_parameters' => '',
                'currency' => 'CLP',
            ]),
            'gateway_response' => collect([
                'status' => 'success',
                'message' => 'successful transaction',
            ]),
        ];

        return collect($response);
    }

    public function invalidResponse()
    {
        $response = [
            'status' => 'invalid',
            'type' => '...',
            'another_invalid_values' => [
                'nope' => 'error',
            ],
        ];

        return collect($response);
    }
}
