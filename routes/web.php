<?php

use SebaCarrasco93\LaravelPayku\Http\Controllers\PaykuController;

Route::post('/', [PaykuController::class, 'create'])->name('create');
Route::get('/return/{order}', [PaykuController::class, 'return'])->name('return');
Route::get('/notify/{order}', [PaykuController::class, 'notify'])->name('notify');
