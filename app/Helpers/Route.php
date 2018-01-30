<?php

if (!function_exists('route_lang')) {
    /**
     * Generate Laravel route including defautl lang param.
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    function route_lang(string $name, $params = []): string
    {
        $locale = ['lang' => session('lang') ?? config('app.locale')];

        if (!empty($params)) {
            if (!is_array($params)) {
                $params = [$params];
            }

            array_merge(['lang' => session('lang')], $params);

            return route($name, array_merge(['lang' => session('lang')], $params));
        }

        return route($name, [session('lang')]);
    }
}
