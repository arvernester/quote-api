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
        $locale = ['lang' => session('lang') ?? 'en'];

        if (!empty($params)) {
            if (!is_array($params)) {
                $params = [$params];
            }

            return route($name, array_merge($locale, $params));
        }

        return route($name, $locale);
    }
}
