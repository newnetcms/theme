<?php

if (!function_exists('theme_setting')) {
    function theme_setting($key, $default = null)
    {
        return Theme::setting($key, $default);
    }
}

if (!function_exists('theme_url')) {
    function theme_url($filename): string
    {
        return Theme::url($filename);
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
