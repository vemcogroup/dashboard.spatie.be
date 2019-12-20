<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TweetHistory\TweetHistory;

class DashboardController
{
    public function overview(Request $request)
    {
        return view('index');
    }
    public function development(Request $request)
    {
        return view('dashboards.development')->with([
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

    public function support(Request $request)
    {
        return view('dashboards.support')->with([
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
