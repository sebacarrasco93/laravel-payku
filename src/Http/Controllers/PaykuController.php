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
            'email' => 'required|email',
            'order' => 'required|unique:payku_transactions,id', 
            'subject' => 'required',
            'amount' => 'required|int',
        ]);

        return LaravelPayku::create($data['order'], $data['subject'], $data['amount'], $data['email']);
    }

    public function return($order)
    {
        $detail = LaravelPayku::return($order);

        dd($detail);
    }

    public function notify($order)
    {
        $notify = LaravelPayku::notify($order);

        dd($notify);
    }
}
