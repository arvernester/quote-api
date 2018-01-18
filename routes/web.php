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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::redirect('admin', '/admin/dashboard');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController')->name('admin.dashboard');

    Route::group(['as' => 'admin.'], function () {
        Route::resource('banner', 'BannerController');
        Route::resource('category', 'CategoryController');

        Route::delete('author/{author}/image', 'AuthorController@removePicture')->name('author.removePicture');
        Route::resource('author', 'AuthorController');

        Route::resource('quote', 'QuoteController');

        Route::resource('country', 'CountryController');
        Route::resource('language', 'LanguageController');

        Route::resource('user', 'UserController');
    });
});

Route::group(['namespace' => 'Api', 'middleware' => 'cors', 'prefix' => 'api'], function () {
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

    Route::get('banner/latest', 'BannerController@latest');
});
