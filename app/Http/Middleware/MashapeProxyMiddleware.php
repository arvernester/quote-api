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

            $proxy = env('MASHAPE_PROXY');
            if (empty($proxy) or $mashapeProxy != $proxy) {
                $message = 'https://market.mashape.com/arvernester/kutipan';
                abort(401, $message);
            }
        }

        return $next($request);
    }
}
