<?php

namespace SebaCarrasco93\LaravelPayku;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Traits\Database;

class LaravelPayku
{
    use Database;

    public $client;
    public $minimumKeys = ['base_url', 'public_token', 'private_token'];

    // From API
    public $allowedTransactionsStatuses = ['register', 'pending', 'success', 'failed'];
    public $allowedTransactionsKeys = ['status', 'id', 'created_at', 'order', 'email', 'subject', 'amount'];
    public $allowedPaymentKeys = [
        'start', 'end', 'media', 'transaction_id', 'verification_key', 'authorization_code',
        'last_4_digits', 'installments', 'card_type', 'additional_parameters', 'currency',
    ];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
            ],
            'base_uri' => config('laravel-payku.base_url') . '/'
        ]);

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

    public function postApi(string $order_id, string $subject, int $amountCLP, string $email)
    {
        $body = $this->client->request('POST', 'transaction', [
            'json' => $this->createOrder($order_id, $subject, $amountCLP, $email),
        ])->getBody();
        
        return json_decode($body);
    }

    public function getApi($found)
    {
        $body = $this->client->request('GET', 'transaction/' . $found->order_id)->getBody();

        return json_decode($body);
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
        $response = $this->postApi($order_id, $subject, $amountCLP, $email);
        $database = $this->markAsRegister($order_id, $amountCLP, $response, $email);

        return redirect()->away($response->url);
    }

    public function markAsRegister($order_id, $amountCLP, $response, $email)
    {
        $transaction = new PaykuTransaction();

        return $transaction->markAsRegister($order_id, $amountCLP, $response->id, $email);
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
        $response = $this->getApi($found);

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
