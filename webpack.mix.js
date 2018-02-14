let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableSuccessNotifications();

mix.js('resources/assets/js/app.js', 'public/js');

/**
 * Minify asset
 */
mix.minify('public/css/main.css')

/**
 * Combine CSS for Lumino admin CSS
 */
mix.styles([
    'public/lumino/css/bootstrap.css',
    'public/lumino/css/font-awesome.min.css',
    'public/lumino/css/datepicker3.css',
    'public/lumino/css/styles.css',
    'public/lumino/css/custom.css',

    // icheck for bootstrap
    'node_modules/icheck-bootstrap/icheck-bootstrap.css'
], 'public/lumino/css/all.css');

mix.minify('public/lumino/css/all.css');

/**
 * Combine CSS for Lumino JS
 */
mix.scripts([
    'public/lumino/js/bootstrap.js',
    'lumino/js/bootstrap-datepicker.js',
    'lumino/js/custom.js'
], 'public/lumino/js/all.js')