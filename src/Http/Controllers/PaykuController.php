<?php

namespace SebaCarrasco93\LaravelPayku\Http\Controllers;

use SebaCarrasco93\LaravelPayku\Facades\LaravelPayku;
use Illuminate\Http\Request;

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

    public function return($orderId)
    {
        return LaravelPayku::return($orderId);
    }

    public function notify($orderId)
    {
        return LaravelPayku::notify($orderId);
    }
}
