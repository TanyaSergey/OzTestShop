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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', "ProductController@accountProduct")->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get("user", "UserController@index");
    Route::post("user/edit/{id}", "UserController@edit");
    Route::post("user/update/{id}", "UserController@update");
    Route::get("products", "ProductController@accountProduct");
    Route::get("products/create", "ProductController@create");
    Route::post("products/save", "ProductController@saveProduct");
    Route::get("products/edit/{product_id}", "ProductController@editProduct");
    Route::post("products/update/{product_id}", "ProductController@updateProduct");
    Route::post("product/sorted", "ProductController@sortedProducts");
});

Route::post("product/{product_id?}", "ProductController@getProduct");
Route::post("cart", "CartController@getCart");
//
//
Route::get('/', "MainPageController@index");
Route::post('/', "MainPageController@getProducts");
Route::get("product/{product_id?}", "ProductController@index");
Route::post("cart/add", "CartController@add");
Route::get("cart", "CartController@index");
Route::get("cart/delete/{product_id}", "CartController@delete");
Route::post("order/buy", "BuyController@buy");
Route::get("products/buy", "ProductController@boughtProduct");
Route::get("products/sales", "ProductController@sales");
Route::post("product/sorted", "ProductController@sortedProducts");