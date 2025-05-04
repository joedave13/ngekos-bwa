<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::controller(CategoryController::class)
    ->prefix('category')
    ->name('category.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{category:slug}', 'show')->name('show');
    });

Route::controller(BoardingHouseController::class)
    ->prefix('boarding-house')
    ->name('boarding-house.')
    ->group(function () {
        Route::get('/find', 'find')->name('find');
        Route::get('/find-result', 'findResult')->name('find-result');
    });

Route::controller(TransactionController::class)
    ->prefix('transaction')
    ->name('transaction.')
    ->group(function () {
        Route::get('/check', 'check')->name('check');
    });
