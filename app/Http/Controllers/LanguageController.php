<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Generate language string based on selected locale.
     */
    public function lang()
    {
        \Debugbar::disable();

        $locale = session('lang');

        // get language from php file
        $files = glob(resource_path('lang/'.$locale.'/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        // get language from json file
        $file = json_decode(File::get(resource_path('lang/'.$locale.'.json')), true);

        return response('window.i18n = '.json_encode(array_merge($strings, $file)))
            ->header('Content-type', 'text/javascript');
    }
}
