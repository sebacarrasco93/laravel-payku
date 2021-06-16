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

    // // Step 1: Register transaction
    // public function markAsRegister(string $id, int $amount, string $order_id, string $email)
    // {
    //     $array = compact('id', 'amount', 'order_id', 'email');
    //     $array['status'] = 'register';

    //     return $this->create($array);
    // }

    // public function search(string $id)
    // {
    //     $found = $this->find($id);

    //     if ($found) {
    //         return $found;
    //     }

    //     throw new \Exception('Invalid ID');
    // }

    // public function complete(string $id, $array)
    // {
    //     $found = $this->search($id);

    //     $updatedTransaction = $found->update(collect($array)
    //         ->only('status', 'created_at', 'email', 'subject', 'amount')
    //         ->toArray()
    //     );

    //     $markAsPaid = $this->markAsPaid($id, collect(collect($array)['payment'])->toArray());

    //     if ($updatedTransaction && $markAsPaid) {
    //         return true;
    //     }
    // }

    // public function markAsPaid(string $id, array $array)
    // {
    //     return $this->search($id)->payment()->create([
    //         'start' => date($array['start']),
    //         'end' => date($array['end']),
    //         'media' => 'Weypay',
    //         'verification_key' => $array['verification_key'],
    //         'authorization_code' => $array['authorization_code'],
    //         'currency' => $array['currency'],
    //     ]);
    // }
}
