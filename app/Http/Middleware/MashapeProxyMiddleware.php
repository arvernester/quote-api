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
        if (app()->environment('local')) {
            $mashapheProxy = $request->header('X-Mashape-Proxy-Secret');

            $message = __('Direct access to API is disabled. Please visit https://market.mashape.com/arvernester/kutipan to get more information about API.');
            abort_if($mashapheProxy != env('MASHAPE_PROXY'), 401, $message);
        }

        return $next($request);
    }
}
