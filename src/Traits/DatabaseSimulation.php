<?php

namespace SebaCarrasco93\LaravelPayku\Traits;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;

trait DatabaseSimulation
{
    public function completeTransaction($order_id, $response)
    {
        $response = collect($response);

        $transaction = new PaykuTransaction();
        
        $updated_transaction = $transaction->complete($order_id, [
            'status' => 'success',
            'order_id' => 100,
            'subject' => 'Test',
            'email' => 'seba@sextanet.cl',
        ]);
    }

    public function storePayment($response)
    {
        $response = collect($response)->toArray();

        $found = PaykuTransaction::firstWhere('order_id', $response['id']);

        return $found->payment()->create($response);
    }
}
