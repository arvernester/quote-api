<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Language;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LanguageComposer
{
    public function compose(View $view)
    {
        $files = glob(resource_path('lang/*.json'));
        $langs = array_map(function ($file) {
            $lang = explode(DIRECTORY_SEPARATOR, $file);

            return str_replace('.json', null, end($lang));
        }, $files);

        $nextMonth = Carbon::now()->addDay(30);

        $languages = Cache::remember('languages', $nextMonth, function () use ($langs) {
            return Language::orderBy('name', 'ASC')
                ->whereIn('code_alternate', $langs)
                ->with('country')
                ->get();
        });

        $view->with('langs', $languages);
    }
}
