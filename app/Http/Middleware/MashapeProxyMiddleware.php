<?php

namespace App\Http\Middleware;

use Closure;

class MashapeProxyMiddleware
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
        if (!app()->environment('local')) {
            $mashapeProxy = $request->header('X-Mashape-Proxy-Secret');

            if (!empty(env('MASHAPE_PROXY')) and ($mashapeProxy == env('MASHAPE_PROXY'))) {
                return $next($request);
            }
        }

        $message = __('Direct access to API is disabled. Please visit https://market.mashape.com/arvernester/kutipan to get more information about API.');
        abort(401, $message);
    }
}
