<?php

namespace SebaCarrasco93\LaravelPayku;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Traits\Database;

class LaravelPayku
{
    use Database;

    public $client;
    public $minimumKeys = ['base_url', 'public_token', 'private_token'];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();

        $this->hasValidConfig();
    }

    public function knowFilledKeys()
    {
        $found = [];
        
        foreach ($this->minimumKeys as $key) {
            $found[$key] = isset(config('laravel-payku')[$key]);
        }

        return array_filter($found);
    }

    public function hasValidConfig()
    {
        $count = count($this->minimumKeys);

        if (count($this->knowFilledKeys()) == $count) {
            return true;
        }

        throw new \Exception('Please set all keys in your .env file');
    }

    public function createOrder(string $order_id, string $subject, int $amountCLP, string $email, $paymentId = 1)
    {
        return [
            'email' => $email,
            'order' => $order_id, 
            'subject' => $subject,
            'amount' => $amountCLP,
            'payment' => $paymentId, // Weppay
            'urlreturn' => route('payku.return', $order_id),
            'urlnotify' => route('payku.notify', $order_id),
        ];
    }

    public function create(string $order_id, string $subject, int $amountCLP, string $email)
    {
        $body = $this->client->request('POST', config('laravel-payku.base_url') . '/transaction', [
            'json' => $this->createOrder($order_id, $subject, $amountCLP, $email),
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
            ]
        ])->getBody();
        
        $response = json_decode($body);

        $this->initTransaction($order_id, $amountCLP, $response);

        return redirect()->away($response->url);
    }

    public function initTransaction($order_id, $amountCLP, $response)
    {
        $transaction = new PaykuTransaction();

        return $transaction->init($order_id, $amountCLP, $response->id);
    }

    // public function returnOrder(string $order_id)
    // {
    //     return $order_id;
    // }

    public function findById(string $id)
    {
        $transaction = new PaykuTransaction();

        return $transaction->find($id);
    }

    public function return(string $id)
    {
        $found = $this->findById($id);

        $body = $this->client->request('GET', config('laravel-payku.base_url') . '/transaction/' . $found->order_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
            ]
        ])->getBody();

        $response = json_decode($body);

        return $this->completeTransaction($found->id, $response);
    }

    public function completeTransaction($order_id, $response)
    {
        $transaction = new PaykuTransaction();
        
        return $transaction->complete($order_id, $response);
    }

    public function notify(string $order_id)
    {
        dd($order_id);
    }
}
