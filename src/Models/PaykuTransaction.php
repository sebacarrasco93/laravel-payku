<?php

namespace SebaCarrasco93\LaravelPayku\Models;

use Illuminate\Database\Eloquent\Model;

class PaykuTransaction extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function payment()
    {
        return $this->hasOne(PaykuPayment::class, 'transaction_id');
    }

    public function scopeRegister($query)
    {
        $query->where('status', 'register');
    }

    public function scopeSuccess($query)
    {
        $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        $query->where('status', 'pending');
    }

    public function markAsNotified()
    {
        return $this->update(['notified_at' => now()]);
    }

    public function notifyForFirstTime()
    {
        if (! $this->notified_at) {
            return $this->markAsNotified();
        }
    }
}
