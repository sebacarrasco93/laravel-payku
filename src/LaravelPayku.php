<?php

namespace SebaCarrasco93\LaravelPayku;

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

    public function createOrder(string $orderId, string $subject, int $amountCLP, string $email, $paymentId = 1)
    {
        return [
            'email' => $email,
            'order' => $orderId, 
            'subject' => $subject,
            'amount' => $amountCLP,
            'payment' => $paymentId, // Weppay
            'urlreturn' => route('payku.return', $orderId),
            'urlnotify' => route('payku.notify', $orderId),
        ];
    }

    public function create(string $orderId, string $subject, int $amountCLP, string $email)
    {
        $body = $this->client->request('POST', config('laravel-payku.base_url') . '/transaction', [
            'json' => $this->createOrder($orderId, $subject, $amountCLP, $email),
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
            ]
        ])->getBody();
        
        $response = json_decode($body);

        $this->storeTransaction($response, $amountCLP);

        // dd($response);

        return redirect()->away($response->url);
    }

    public function returnOrder(string $orderId)
    {
        return $orderId;
    }

    public function return(string $transactionId)
    {
        $body = $this->client->request('GET', config('laravel-payku.base_url') . '/transaction/' . $transactionId, [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
            ]
        ])->getBody();

        $response = json_decode($body);

        $this->storePayment($response);

        dd($response);
    }

    public function notify(string $transactionId)
    {
        dd($transactionId);
    }
}
