<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaypalPaymentController;

Route::get('/', function () {
    return view('home');
});

Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
    Route::controller(StripePaymentController::class)->group(function () {
        Route::get('home', 'index')->name('index');
        Route::post('', 'store')->name('store');
    });
});

Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
    Route::controller(PaypalPaymentController::class)->group(function () {
        Route::get('home', 'index')->name('index');
        Route::post('', 'store')->name('store');
    });
});

Route::group(['prefix' => 'bkash', 'as' => 'bkash.'], function () {
    Route::controller(PaypalPaymentController::class)->group(function () {
        Route::get('home', 'index')->name('index');
        Route::post('', 'store')->name('store');
    });
});
