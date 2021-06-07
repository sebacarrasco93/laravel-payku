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

    public function complete(string $order_id, array $array)
    {
        $found = $this->firstWhere('order_id', $order_id);

        if ($found) {
            return $found->update($array);
        }

        throw new \Exception('Invalid ID');
    }
}
