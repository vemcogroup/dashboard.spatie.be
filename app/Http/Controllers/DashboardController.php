<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\TweetHistory\TweetHistory;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard')->with([
            'socketAppKey' => config('services.pusher.key'),
            'socketCluster' => config('services.pusher.cluster'),
            'socketHost' => config('services.pusher.host'),
            'socketPort' => (int) config('services.pusher.port'),
            'socketSecurePort' => (int) config('services.pusher.secure_port'),
            'socketDisableStats' => (bool) config('services.pusher.disable_stats'),
            'socketEncrypted' => (bool) config('services.pusher.encrypted'),

            'initialTweets' => TweetHistory::all(),
        ]);
    }
}
