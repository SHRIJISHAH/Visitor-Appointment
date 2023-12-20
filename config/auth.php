<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'superadmin' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],

        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'provider' => [
            'driver' => 'session',
            'provider' => 'providers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Superadmin::class,
        ],

        'providers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Provider::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
