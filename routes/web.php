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

Route::get('/', 'PageController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Api', 'middleware' => 'cors', 'prefix' => 'api'], function () {
    Route::get('quote', 'QuoteController@index');
    Route::get('quote/random', 'QuoteController@random');
    Route::get('quote/latest', 'QuoteController@latest');
    Route::get('quote/{quote}', 'QuoteController@show');
    Route::post('quote', 'QuoteController@store');

    Route::get('category', 'CategoryController@index');
    Route::get('category/random', 'CategoryController@random');
    Route::get('category/{category}', 'CategoryController@show');

    Route::get('language', 'LanguageController@index');
});
