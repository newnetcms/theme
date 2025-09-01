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
];
