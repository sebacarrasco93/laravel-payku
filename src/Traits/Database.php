<?php

namespace SebaCarrasco93\LaravelPayku\Traits;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;

trait Database
{
    public function storeTransaction($response)
    {
        $response = collect($response);

        return PaykuTransaction::updateOrCreate([
            'order_id' => $response['id'],
        ], [
            'order_id' => $response['id'],
            'amount' => $response['amount'],
            'status' => $response['status'] ?? null,
            'id' => $response['id'] ?? null,
            'email' => $response['email'] ?? null,
            'subject' => $response['subject'] ?? null,
            'amount' => $response['amount'] ?? null,
        ]);
    }

    public function storePayment($response)
    {
        $response = collect($response)->toArray();

        $found = PaykuTransaction::firstWhere('order_id', $response['id']);

        return $found->payment()->create($response);
    }
}
