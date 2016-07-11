<?php
return [
    'defaults'  => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],
    'guards'    => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver'   => 'token',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => Determine\Service\Guess\User::class,
        ],
//        'users' => [
//            'driver' => 'database',
//            'table'  => 'users',
//        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email'    => 'auth.emails.password',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],
];
