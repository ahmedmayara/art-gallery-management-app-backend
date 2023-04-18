<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'v1'], function() {
        Route::apiResource('artists', 'App\Http\Controllers\Api\V1\ArtistController');
        Route::apiResource('customers', 'App\Http\Controllers\Api\V1\CustomerController');
        Route::apiResource('categories', 'App\Http\Controllers\Api\V1\CategoryController');
        Route::apiResource('artboards', 'App\Http\Controllers\Api\V1\ArtboardController');
        Route::apiResource('orders', 'App\Http\Controllers\Api\V1\OrderController');
        Route::post('logout', 'App\Http\Controllers\Api\V1\AuthController@logout');
        Route::get('users', 'App\Http\Controllers\Api\V1\UserController@index');
        Route::put('orders/{order}/approve', 'App\Http\Controllers\Api\V1\OrderController@approveOrder');
        Route::put('orders/{order}/reject', 'App\Http\Controllers\Api\V1\OrderController@rejectOrder');
    });
});

Route::post('v1/register', 'App\Http\Controllers\Api\V1\AuthController@register');
Route::post('v1/login', 'App\Http\Controllers\Api\V1\AuthController@login');
Route::get('v1/orders', 'App\Http\Controllers\Api\V1\OrderController@index');
Route::get('artboards/all', 'App\Http\Controllers\Api\V1\ArtboardController@all');
Route::get('artboards/{category}', 'App\Http\Controllers\Api\V1\ArtboardController@getArtboardsByCategory');


