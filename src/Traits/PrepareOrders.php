<?php

namespace SebaCarrasco93\LaravelPayku\Traits;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;

trait PrepareOrders
{
    public function prepareOrder(string $order, string $subject, int $amountCLP, string $email, $paymentId = 1)
    {
        return [
            'email' => $email,
            'order' => $order, 
            'subject' => $subject,
            'amount' => $amountCLP,
            'payment' => $paymentId, // Weppay
            'urlreturn' => route('payku.return', $order),
            'urlnotify' => route('payku.notify', $order),
        ];
    }
}
