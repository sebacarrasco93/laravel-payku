<?php

namespace SebaCarrasco93\LaravelPayku;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Traits\DatabaseSimulation;
use SebaCarrasco93\LaravelPayku\Traits\PrepareOrders;
use Illuminate\Support\Collection;

class LaravelPayku
{
    use DatabaseSimulation, PrepareOrders;

    // From Response API
    public $hasValidResponse = false;
    public $status, $id, $created_at, $order, $email, $subject, $amount;

    // URLs
    const URL_API_DEV = 'https://des.payku.cl/api';
    const URL_API_PROD = 'https://app.payku.cl/api';

    // For API Interaction...
    public $client;
    public $minimumApiKeys = ['public_token', 'private_token'];

    // For handle with API
    public $allowedTransactionsStatuses = ['register', 'pending', 'success', 'failed'];
    // public $allowedTransactionsKeys = ['status', 'id', 'created_at', 'order', 'email', 'subject', 'amount'];
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
            'base_uri' => $this->apiRoute() . '/'
        ]);

        $this->hasValidConfig();
    }

    public function apiRoute()
    {
        if (config('app.base_url')) {
            return config('app.base_url');
        }
        
        if (config('app.env') == 'production') {
            return self::URL_API_PROD;
        }

        return self::URL_API_DEV;
    }

    public function findApiKeys()
    {
        $found = [];
        
        foreach ($this->minimumApiKeys as $key) {
            $found[$key] = config('laravel-payku')[$key];
        }

        return array_filter($found);
    }

    public function hasValidConfig()
    {
        $count = count($this->minimumApiKeys);

        if (count($this->findApiKeys()) == $count) {
            return true;
        }

        throw new \Exception('Please set all PAYKU keys in your .env file.');
    }

    public function postApi(string $transaction_id, string $subject, int $amountCLP, string $email)
    {
        $body = $this->client->request('POST', 'transaction', [
            'json' => $this->prepareOrder($transaction_id, $subject, $amountCLP, $email),
        ])->getBody();
        
        return json_decode($body, true);
    }

    public function getApi(PaykuTransaction $transaction)
    {
        $body = $this->client->request('GET', 'transaction/' . $transaction->id)->getBody();

        return json_decode($body, true);
    }

    public function handleAPIResponse($response)
    {
        if (! in_array($response['status'], $this->allowedTransactionsStatuses)) {
            throw new \Exception("Invalid response status: " . $response['status']);
        }

        $this->hasValidResponse = true;

        // $this->status = $response['status'];
        foreach ($response as $key => $value) {
            $this->$key = $value;
        }
    }

    public function saveAPIResponse($response)
    {
        $response = collect($response);
        $this->handleAPIResponse($response);
        // dd($response);

        $firstResponse = $response->except('payment', 'gateway_response')->toArray();

        if ($firstResponse['status'] != 'failed') {
            $transaction = PaykuTransaction::updateOrCreate(['id' => $response['id']], $firstResponse);

            if (isset($response['payment'])) {
                $payment = collect($response['payment']);
                if ($payment->count()) {
                    $transaction->payment()->updateOrCreate($payment->toArray());
                }
            }
        }
    }

    public function create(string $transaction_id, string $subject, int $amountCLP, string $email)
    {
        $response = $this->postApi($transaction_id, $subject, $amountCLP, $email);
        $database = $this->saveAPIResponse($response);

        return redirect()->away($response['url']);
    }

    public function return($order)
    {
        $found = PaykuTransaction::whereOrder($order)->firstOrFail();
        $response = $this->getApi($found);
        $this->saveAPIResponse($response);

        return redirect('payku.notify');
    }

    public function notify($order)
    {
        dd($order);
    }
}
