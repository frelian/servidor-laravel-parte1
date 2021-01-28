<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

// Route::get('/', 'HomeController@index')->name('ini');
Route::get('/', 'HomeController@dashboard')->name('dashboard');
Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/{id}', 'UserController@edit')->name('user.edit');
Route::post('/user/{id}', 'UserController@update')->name('user.update');
Route::post('user/destroy/{id}', 'UserController@destroy')->name('user.destroy');
Route::get('/user/create', 'UserController@create')->name('user.create');
Route::post('/userstore', 'UserController@store')->name('userstore');

Route::get('/clients', 'ClientController@index')->name('clients');

Route::group(['prefix' => 'client'], function() {
    Route::post('store', 'ClientController@store')->name('client-store');
    Route::post('/{id}', 'ClientController@show');
    Route::get('/edit/{id}', 'ClientController@edit')->name('client-edit');
    Route::post('/update/{id}', 'ClientController@update')->name('client-update');
    Route::post('/destroy/{id}', 'ClientController@destroy')->name('client-destroy');
    Route::get('create', 'ClientController@create')->name('client-create');
    Route::get('assign', 'ClientController@assignIndex')->name('client-assignuser-i');
    Route::post('/assign/user/{id_user}', 'ClientController@assignClient')->name('client-assignuser');
    Route::post('/destroy/assign/user/{id_client}', 'ClientController@assignDestroy')->name('client-assignuser-d');
});

Route::group(['prefix' => 'product'], function() {
    Route::get('create', 'ProductController@create')->name('product-create');
    Route::get('/{buscado?}/{page?}', 'ProductController@index')->name('products');
    Route::get('/edit/p/{id}', 'ProductController@edit')->name('product-edit');
    Route::post('/update/{id}', 'ProductController@update')->name('product-update');
    Route::post('destroy/{id}', 'ProductController@destroy')->name('product-destroy');
    Route::post('store', 'ProductController@store')->name('product-store');
});

Route::post('/assign/client-products', 'ClientProductController@store')->name('clientproducts-store');
Route::get('/client-products/destroy/{id}', 'ClientProductController@destroy')->name('clientproducts-destroy');

Route::group(['prefix' => 'types'], function() {
    Route::post('/', 'ClientTypeController@index')->name('types');
    Route::get('/edit/{id}', 'ClientTypeController@edit')->name('types-edit');
    Route::post('/update/{id}', 'ClientTypeController@update')->name('types-update');
    Route::post('/destroy/{id}', 'ClientTypeController@destroy')->name('types-destroy');
    Route::get('create', 'ClientTypeController@create')->name('types-create');
    Route::post('store', 'ClientTypeController@store')->name('types-store');
});

Route::group(['prefix' => 'sales'], function() {
    Route::get('/{buscado?}/{page?}', 'SaleController@index')->name('sales');
    Route::get('/edit/{id}', 'SaleController@edit')->name('sales-edit');
    Route::post('/update/{id}', 'SaleController@update')->name('sales-update');
    Route::post('/destroy/{id}', 'SaleController@destroy')->name('sales-destroy');
    Route::get('create', 'SaleController@create')->name('sales-create');
    Route::post('store', 'SaleController@store')->name('sales-store');
});

Auth::routes();
Route::get('/home', 'HomeController@home')->name('home');
