<?php

use Illuminate\Support\Str;

if (!function_exists('theme_setting')) {
    function theme_setting($key, $default = null)
    {
        return setting($key, $default);
    }
}

if (!function_exists('theme_url')) {
    function theme_url(string $filename, bool $fullUrl = false): string
    {
        $theme = Theme::current();

        /*
         * 1. Xác định có /public trong assets hay không
         */
        $hasPublic = config('cms.theme.asset_has_public');

        // Auto-detect nếu config = null (backward compatible)
        if ($hasPublic === null) {
            $assetFolder = config('cms.theme.asset_folder', 'assets');

            $hasPublic = is_dir(
                public_path("themes/{$theme}/public/{$assetFolder}")
            );
        }

        /*
         * 2. Asset folder (assets / static / v.v.)
         */
        $assetFolder = config('cms.theme.asset_folder', 'assets');

        $publicSegment = $hasPublic ? '/public' : '';

        $path = "themes/{$theme}{$publicSegment}/{$assetFolder}/" . ltrim($filename, '/');

        return $fullUrl ? asset($path) : '/' . $path;
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
