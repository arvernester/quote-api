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

Route::redirect('api', ' https://market.mashape.com/arvernester/kutipan')->name('api');

Route::get('quote/poster/{slug}.png', 'QuoteController@poster')->name('quote.poster');

Route::get('js/lang.js', 'LanguageController@lang')->name('language.lang');
Route::post('contact/post', 'ContactController@post')->name('contact.post');
Route::get('share/twitter/{quote}', 'ShareController@twitter')->name('share.twitter');
Route::get('share/facebook/{quote}', 'ShareController@facebook')->name('share.facebook');
Route::post('translation/translate', 'TranslationController@translate')->name('translation.translate');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::redirect('admin', '/admin/dashboard');
Route::middleware('locale', 'auth')->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('dashboard', 'DashboardController')->name('admin.dashboard');

    Route::group(['as' => 'admin.'], function () {
        Route::resource('banner', 'BannerController');

        Route::get('category/poster/{category}', 'CategoryController@poster')->name('category.poster');
        Route::post('category/poster/{category}', 'CategoryController@uploadPoster')->name('category.poster.store');
        Route::get('category/merge', 'CategoryController@merge')->name('category.merge');
        Route::put('category/updateable', 'CategoryController@updateable')->name('category.updateable');
        Route::put('category/fuse', 'CategoryController@fuse')->name('category.fuse');
        Route::resource('category', 'CategoryController');

        Route::put('author/updateable', 'AuthorController@updateable')->name('author.updateable');
        Route::delete('author/{author}/image', 'AuthorController@removePicture')->name('author.removePicture');
        Route::resource('author', 'AuthorController');

        Route::put('author/profile/updateable', 'AuthorProfileController@updateable')->name('author.profile.updateable');

        Route::get('quote/poster/{quote}', 'QuoteController@poster')->name('quote.poster');
        Route::post('quote/poster/{quote}', 'QuoteController@uploadPoster')->name('quote.poster.store');
        Route::get('quote/submitted', 'QuoteController@submitted')->name('quote.submitted');
        Route::resource('quote', 'QuoteController');

        Route::resource('country', 'CountryController');
        Route::resource('language', 'LanguageController');

        Route::resource('user', 'UserController');

        // account management
        Route::get('profile', 'Account\ProfileController@edit')->name('account.profile.edit');
        Route::put('profile', 'Account\ProfileController@update')->name('account.profile.update');

        Route::post('notification/read', 'NotificationController@read');
    });
});

Route::prefix('{lang?}')->middleware('locale')->group(function () {
    Route::get('/', 'IndexController')->name('index');

    Route::get('random', 'QuoteController@random')->name('quote.random');
    Route::get('quote', 'QuoteController@index')->name('quote.index');
    Route::get('quote/create', 'QuoteController@create')->name('quote.create');
    Route::get('quote/{quote}', 'QuoteController@show')
        ->name('quote.show')
        ->where(['quote' => '[0-9]+']);
    Route::post('quote', 'QuoteController@store')->name('quote.store');
    Route::get('feed.json', 'QuoteController@feed')->name('quote.feed');

    Route::get('category', 'CategoryController@index')->name('category.index');

    Route::get('author/{author}', 'AuthorController@show')
        ->name('author.show')
        ->where(['author' => '[0-9]+']);
    Route::get('author/{slug}', 'AuthorController@showBySlug')
        ->name('author.show.slug')
        ->where(['slug' => '[A-Za-z0-9\-\_]+']);

    Route::get('category/{category}', 'CategoryController@show')->name('category.show');

    Route::get('{slug}', 'QuoteController@showBySlug')
        ->name('quote.show.slug')
        ->where(['slug' => '[A-Za-z0-9\-\_]+']);
});
