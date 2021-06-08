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

    public function init(string $id, int $amount)
    {
        $this->create([
            'id' => $id,
            'amount' => $amount,
        ]);
    }

    public function complete(string $id, $array)
    {
        $found = $this->find($id);

        if ($found) {
            return $found->update($array);
        }

        throw new \Exception('Invalid ID');
    }

    public function markAsPaid(string $id, array $array)
    {
        $found = $this->find($id);

        if ($found) {
            return $found->payment()->create([
                'start' => date($array['start']),
                'end' => date($array['end']),
                'media' => 'Weypay',
                'verification_key' => $array['verification_key'],
                'authorization_code' => $array['authorization_code'],
                'currency' => $array['currency'],
            ]);
        }

        throw new \Exception('Invalid ID');
    }
}
