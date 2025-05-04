<?php

use App\Http\Controllers\Api\MidtransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return 'Hi';
});

Route::prefix('webhook')->group(function () {
    Route::post('callback', [MidtransController::class, 'callback']);
});
