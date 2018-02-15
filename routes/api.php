<?php


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

Route::group(['namespace' => 'Api'], function () {
    Route::get('quote', 'QuoteController@index');
    Route::get('quote/random', 'QuoteController@random');
    Route::get('quote/of-the-day', 'QuoteController@quoteOfTheDay');
    Route::get('quote/author', 'QuoteController@author');
    Route::get('quote/category', 'QuoteController@category');
    Route::get('quote/latest', 'QuoteController@latest');
    Route::get('quote/{quote}', 'QuoteController@show');
    Route::post('quote', 'QuoteController@store');

    Route::get('category', 'CategoryController@index');
    Route::get('category/random', 'CategoryController@random');
    Route::get('category/{category}', 'CategoryController@show');

    Route::get('language', 'LanguageController@index');
});
