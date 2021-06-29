<?php

namespace SebaCarrasco93\LaravelPayku;

use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;
use SebaCarrasco93\LaravelPayku\Traits\DatabaseSimulation;
use SebaCarrasco93\LaravelPayku\Traits\PrepareOrders;
use GuzzleHttp\Client as GuzzleClient;
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
        $this->client = new GuzzleClient([
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-payku.public_token'),
                'User-Agent' => 'sebacarrasco93/laravel-payku'
            ],
            'base_uri' => $this->apiRoute() . '/'
        ]);

        $this->hasValidConfig();
    }

    public function apiRoute()
    {
        if (config('laravel-payku.base_url')) {
            return config('laravel-payku.base_url');
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

    public function saveAPIResponse($response, $transaction_id = null)
    {
        $response = collect($response);
        $this->handleAPIResponse($response);
        // dd($response);

        if ($transaction_id) { // Creating...
            $response['order'] = $transaction_id;
        }

        $firstResponse = $response->except('payment', 'gateway_response')->toArray();

        if ($firstResponse['status'] != 'failed') {
            $transaction = PaykuTransaction::updateOrCreate(['id' => $response['id']], $firstResponse);

            if (isset($response['payment'])) {
                $payment = collect($response['payment']);
                if ($payment->count()) {
                    $transaction->payment()->create($payment->toArray());
                }
            }
        } else {
            throw new \Exception("Can't create your transaction with ID ${transaction_id}");
        }
    }

    public function create(string $transaction_id, string $subject, int $amountCLP, string $email)
    {
        $response = $this->postApi($transaction_id, $subject, $amountCLP, $email);
        $database = $this->saveAPIResponse($response, $transaction_id);

        return redirect()->away($response['url']);
    }

    public function return($order)
    {
        $found = PaykuTransaction::whereOrder($order)->firstOrFail();
        $response = $this->getApi($found);
        $this->saveAPIResponse($response);

        return redirect()->route('payku.notify', $order);
    }

    public function notify($order)
    {
        return PaykuTransaction::whereOrder($order)->firstOrFail();
    }

    public function findById($id)
    {
        return PaykuTransaction::whereId($id)->firstOrFail();
    }

    public function hasStatusSuccess($id)
    {
        return $this->findById($id)->status == 'success';
    }

    public function hasStatusPending($id)
    {
        return $this->findById($id)->status == 'pending';
    }
}
