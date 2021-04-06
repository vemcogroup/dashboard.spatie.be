<?php

namespace App\Providers;

use App\Events\Alarms\QueueAlarm;
use App\Services\SendQueueWaitSmsAlert;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\Twitter\Mentioned::class => [
            \App\Services\TweetHistory\TweetHistory::class,
        ],
        QueueAlarm::class => [
            SendQueueWaitSmsAlert::class,
        ]
    ];

    protected $subscribe = [
        \App\Services\OhDearWebhooks\EventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
