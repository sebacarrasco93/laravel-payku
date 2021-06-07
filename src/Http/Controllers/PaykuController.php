<?php

namespace SebaCarrasco93\LaravelPayku\Http\Controllers;

use Illuminate\Http\Request;
use SebaCarrasco93\LaravelPayku\Facades\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;

class PaykuController
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'order' => 'required', 
            'subject' => 'required',
            'amount' => 'required',
        ]);

        return LaravelPayku::create($data['order'], $data['subject'], $data['amount'], $data['email']);
    }

    public function return($transactionId)
    {
        $transaction = PaykuTransaction::findOrFail($transactionId);

        return LaravelPayku::return($transaction->order_id);
    }

    public function notify($transactionId)
    {
        $transaction = PaykuTransaction::findOrFail($transactionId);

        return LaravelPayku::notify($transaction->order_id);
    }
}
