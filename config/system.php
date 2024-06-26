<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Author Information
    |--------------------------------------------------------------------------
    |
    | Set the details of the package author.
    |
     */

    'author' => [
        'name' => 'Vironeer',
        'email' => 'support@vironeer.com',
        'website' => 'https://vironeer.com',
        'profile' => 'https://codecanyon.net/user/vironeer',
    ],

    /*
    |--------------------------------------------------------------------------
    | Item Information
    |--------------------------------------------------------------------------
    |
    | Define information about the package item.
    |
     */

    'item' => [
        'alias' => 'DoniaWeB',
        'version' => '1.5',
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | Enable or disable the system demo mode.
    |
     */

    'demo_mode' => env('SYSTEM_DEMO_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | License Information
    |--------------------------------------------------------------------------
    |
    | Set the API endpoint and type for license validation.
    |
     */

    /*
    |--------------------------------------------------------------------------
    | Installation Settings
    |--------------------------------------------------------------------------
    |
    | Configure various installation settings.
    |
     */

    'install' => [
        'requirements' => env('INSTALL_REQUIREMENTS', false),
        'file_permissions' => env('INSTALL_FILE_PERMISSIONS', false),
        'license' => env('INSTALL_LICENSE', false),
        'database_info' => env('INSTALL_DATABASE_INFO', false),
        'database_import' => env('INSTALL_DATABASE_IMPORT', false),
        'complete' => env('INSTALL_COMPLETE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Styles
    |--------------------------------------------------------------------------
    |
    | Specify CSS files for the admin section.
    |
     */

    'admin' => [
        'path' => env('SYSTEM_ADMIN_PATH', 'admin'),
        'colors' => 'vendor/admin/css/colors.css',
        'custom_css' => 'vendor/admin/css/custom.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reviewer Styles
    |--------------------------------------------------------------------------
    |
    | Specify CSS files for the reviewer section.
    |
     */

    'reviewer' => [
        'path' => env('SYSTEM_REVIEWER_PATH', 'reviewer'),
        'colors' => 'vendor/reviewer/css/colors.css',
        'custom_css' => 'vendor/reviewer/css/custom.css',
    ],

];