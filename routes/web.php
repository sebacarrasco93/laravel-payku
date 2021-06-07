<?php

use SebaCarrasco93\LaravelPayku\Http\Controllers\PaykuController;

Route::post('/', [PaykuController::class, 'create'])->name('create');
Route::get('/return/{transaction}', [PaykuController::class, 'return'])->name('return');
Route::get('/notify/{transaction}', [PaykuController::class, 'notify'])->name('notify');
