<?php

namespace SebaCarrasco93\LaravelPayku\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebaCarrasco93\LaravelPayku\Facades\LaravelPayku;
use SebaCarrasco93\LaravelPayku\Models\PaykuTransaction;

class PaykuController
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'order' => 'required|unique:payku_transactions,id', 
            'subject' => 'required',
            'amount' => 'required|int',
        ]);

        return LaravelPayku::create($data['order'], $data['subject'], $data['amount'], $data['email']);
    }

    public function return($order)
    {
        $detail = LaravelPayku::return($order);

        return $detail;
    }

    public function notify($order)
    {
        $result = LaravelPayku::notify($order);
        $routeName = config('laravel-payku.route_finish_name');

        $routeExists = Route::has($routeName);
        
        if ($routeExists) {
            return redirect()->route($routeName, $result);
        }

        return view('payku::notify.missing-route', compact('result', 'routeName'));
    }
}
