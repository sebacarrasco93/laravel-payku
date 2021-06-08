<?php

use SebaCarrasco93\LaravelPayku\Http\Controllers\PaykuController;

Route::post('/', [PaykuController::class, 'create'])->name('create');
Route::get('/return/{order_id}', [PaykuController::class, 'return'])->name('return');
Route::get('/notify/{order_id}', [PaykuController::class, 'notify'])->name('notify');
