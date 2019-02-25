<?php

namespace App\Http\Controllers;

use App\Services\TweetHistory\TweetHistory;

class DashboardController
{
    public function __invoke()
    {
        return view('dashboard')->with([
            'socketAppKey' => config('services.pusher.key'),
            'socketCluster' => config('services.pusher.cluster'),
            'socketHost' => config('services.pusher.host'),
            'socketPort' => (int) config('services.pusher.port'),
            'socketSecurePort' => (int) config('services.pusher.secure_port'),
            'socketDisableStats' => (bool) config('services.pusher.disable_stats'),
            'socketEncrypted' => (bool) config('services.pusher.encrypted'),
            'openWeatherMapKey' => config('services.open_weather_map.key'),
            'environment' => app()->environment(),
            'initialTweets' => TweetHistory::all(),
        ]);
    }
}
