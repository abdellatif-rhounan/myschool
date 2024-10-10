<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'frame'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'frames'),
    ],

    'guards' => [
        'frame' => [
            'driver' => 'session',
            'provider' => 'frames',
        ],
        'teacher' => [
            'driver' => 'session',
            'provider' => 'teachers',
        ],
        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],
        'tutor' => [
            'driver' => 'session',
            'provider' => 'tutors',
        ],
    ],

    'providers' => [
        'frames' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Frame::class),
        ],
        'teachers' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Teacher::class),
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Student::class),
        ],
        'tutors' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Tutor::class),
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
