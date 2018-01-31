<?php

namespace App\Http\Middleware;

use Closure;
use App\Language;
use Carbon\Carbon;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty('lang')) {
            session(['lang' => config('app.locale')]);
        }

        if ($request->method() === 'GET') {
            $lang = $request->routeIs('admin.*') ? session('lang') : $request->segment(1);
            if (session('lang') != $lang) {
                $language = Language::whereCodeAlternate($lang)->first();

                session([
                    'lang' => $language->code_alternate ?? 'en',
                ]);
            }
            app()->setLocale(session('lang'));
            Carbon::setLocale(session('lang'));
        }

        return $next($request);
    }
}
