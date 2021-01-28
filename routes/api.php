<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login')->name('api.login');
Route::get('logout', 'API\UserController@logout')->middleware('auth:api');

// Clients
Route::post('clients', 'API\ClientController@index')->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('store/sale', 'API\ClientController@clientStoreProducts');
    Route::post('client/products/{idclient}', 'API\ClientController@clientProducts');
});

Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\UserController@logout');
        Route::get('user', 'API\UserController@user');
    });
});
