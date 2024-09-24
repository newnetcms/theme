<?php

use Illuminate\Support\Str;

if (!function_exists('theme_setting')) {
    function theme_setting($key, $default = null)
    {
        return setting($key, $default);
    }
}

if (!function_exists('theme_url')) {
    function theme_url($filename, $fullUrl = false): string
    {
        if(Str::contains(Theme::path(), public_path())) {
            $public = '/public';
        } else $public = '';

        $theme = Theme::current();
        return $fullUrl ?
            asset("themes/{$theme}{$public}/assets/$filename") :
            "/themes/{$theme}{$public}/assets/$filename";
    }
}

if (!function_exists('theme_demo_options')) {
    function theme_demo_options()
    {
        return [
            [
                'value' => 'foo',
                'label' => 'Foo',
            ],
            [
                'value' => 'bar',
                'label' => 'Bar',
            ],
            [
                'value' => 'baz',
                'label' => 'Baz',
            ],
        ];
    }
}
