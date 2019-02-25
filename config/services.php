<?php

return [

    'pusher' => [
        'key' => env('PUSHER_APP_KEY', ''),
        'cluster' => env('PUSHER_APP_CLUSTER', ''),
        'host' => env('PUSHER_APP_HOST', ''),
        'port' => env('PUSHER_APP_PORT', 80),
        'secure_port' => env('PUSHER_APP_SECURE_PORT', 443),
        'disable_stats' => env('PUSHER_APP_DISABLE_STATS', false),
        'encrypted' => env('PUSHER_APP_ENCRYPTED', false),
    ],

    'github' => [
        'token' => env('GITHUB_TOKEN'),
        'files' => env('GITHUB_FILES'),
        'hook_secret' => env('GITHUB_HOOK_SECRET'),
        'username' => env('GITHUB_USERNAME'),
    ],

    'last-fm' => [
        'api_key' => env('LAST_FM_API_KEY'),
        'users' => explode(',', env('LAST_FM_USERS')),
    ],

    'pusher' => [
        'key' => env('PUSHER_APP_KEY', ''),
        'cluster' => env('PUSHER_APP_CLUSTER', ''),
        'host' => env('PUSHER_APP_HOST', ''),
        'port' => env('PUSHER_APP_PORT', 80),
        'secure_port' => env('PUSHER_APP_SECURE_PORT', 443),
        'disable_stats' => env('PUSHER_APP_DISABLE_STATS', false),
        'encrypted' => env('PUSHER_APP_ENCRYPTED', false),
    ],

    'packagist' => [
        'vendor' => env('PACKAGIST_VENDOR'),
    ],

    'velo' => [
        'stations' => explode(',', env('VELO_STATIONS')),
    ],

    'buienradar' => [
        'latitude' => env('BUIENRADAR_LATITUDE'),
        'longitude' => env('BUIENRADAR_LONGITUDE'),
    ],

    'open_weather_map' => [
        'key' => env('OPEN_WEATHER_MAP_KEY'),
    ],

    'slack' => [
        'app_token' => env('SLACK_APP_TOKEN'),
    ],

    'train_connections' => [
        [
            'departure' => 'Antwerpen-Centraal',
            'destination' => 'Gent-Dampoort',
            'label' => 'Gent'
        ],
        [
            'departure' => 'Antwerpen-Centraal',
            'destination' => 'Mechelen',
            'label' => 'Mechelen',
        ],
        [
            'departure' => 'Antwerpen-Centraal',
            'destination' => 'Overpelt',
            'label' => 'Overpelt',
        ],
    ],
];
