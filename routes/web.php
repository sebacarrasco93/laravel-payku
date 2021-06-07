<?php

use SebaCarrasco93\LaravelPayku\Http\Controllers\PaykuController;

Route::post('/', [PaykuController::class, 'create'])->name('create');
Route::get('/return/{orderNumber}', [PaykuController::class, 'return'])->name('return');
Route::get('/notify/{orderNumber}', [PaykuController::class, 'notify'])->name('notify');
