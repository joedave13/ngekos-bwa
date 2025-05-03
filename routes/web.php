<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::controller(TransactionController::class)->prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/check', 'check')->name('check');
});
