<?php

namespace SebaCarrasco93\LaravelPayku\Models;

use Illuminate\Database\Eloquent\Model;

class PaykuTransaction extends Model
{
    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne(PaykuPayment::class, 'transaction_id');
    }

    public function init(string $id, int $amount, string $order_id)
    {
        return $this->create([
            'id' => $id,
            'amount' => $amount,
            'order_id' => $order_id,
            'status' => 'register',
        ]);
    }

    public function search(string $id)
    {
        $found = $this->find($id);

        if ($found) {
            return $found;
        }

        throw new \Exception('Invalid ID');
    }

    public function complete(string $id, $array)
    {
        $found = $this->search($id);

        $array = collect($array)->only('status', 'created_at', 'email', 'subject', 'amount')->toArray();

        $updated = $found->update($array);
    }

    public function markAsPaid(string $id, array $array)
    {
        return $this->search($id)->payment()->create([
            'start' => date($array['start']),
            'end' => date($array['end']),
            'media' => 'Weypay',
            'verification_key' => $array['verification_key'],
            'authorization_code' => $array['authorization_code'],
            'currency' => $array['currency'],
        ]);
    }
}
