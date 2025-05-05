<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
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

Route::controller(CityController::class)
    ->prefix('city')
    ->name('city.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{city:slug}', 'show')->name('show');
    });

Route::controller(BoardingHouseController::class)
    ->prefix('boarding-house')
    ->name('boarding-house.')
    ->group(function () {
        Route::get('/find', 'find')->name('find');
        Route::get('/find-result', 'findResult')->name('find-result');
        Route::get('/{boardingHouse:slug}', 'show')->name('show');
        Route::get('/{boardingHouse:slug}/rooms', 'showAvailableRoom')->name('show-available-room');
    });

Route::controller(TransactionController::class)
    ->prefix('transaction')
    ->name('transaction.')
    ->group(function () {
        Route::get('/check', 'check')->name('check');
        Route::post('/check', 'checkResult')->name('check-result');

        Route::post('/boarding-house-room/save', 'saveBoardingHouseRoom')->name('boarding-house-room.save');

        Route::get('/customer-information', 'customerInformation')->name('customer-information');
        Route::post('/customer-information', 'saveCustomerInformation')->name('customer-information.save');

        Route::get('/checkout', 'checkout')->name('checkout');
        Route::post('/checkout', 'checkoutSave')->name('checkout.save');

        Route::get('/success', 'success')->name('success');

        Route::get('/{transaction:code}', 'show')->name('show');
    });
