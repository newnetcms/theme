<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | It will assign the default active theme to be used if one is not set during
    | runtime.
    */
    'current_theme' => env('CMS_CURRENT_THEME'),

    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | The base path where all the themes are located.
    */
    'base_path' => public_path('themes'),

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode
    |--------------------------------------------------------------------------
    |
    | Determines whether the application is currently running in maintenance
    | mode. When enabled, users will see a maintenance notice instead of
    | accessing the normal application content.
    */
    'maintenance_mode' => env('MAINTENANCE_MODE'),

    /*
    |--------------------------------------------------------------------------
    | Asset structure
    |--------------------------------------------------------------------------
    |
    | If true:
    |   themes/{theme}/public/assets/...
    | If false:
    |   themes/{theme}/assets/...
    */
    'asset_has_public' => env('CMS_THEME_ASSET_HAS_PUBLIC', true),

    /*
    |--------------------------------------------------------------------------
    | Asset folder name
    |--------------------------------------------------------------------------
    |
    | Allow future customization if needed
    */
    'asset_folder' => env('CMS_THEME_ASSET_FOLDER', 'assets'),
];
