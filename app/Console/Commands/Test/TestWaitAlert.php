<?php

namespace App\Console\Commands\Test;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\Alarms\QueueAlarm;

class TestWaitAlert extends Command
{
    protected $signature = 'test:wait-alert';

    protected $description = 'Test wait alert';

    protected $stats = [];

    public function handle(): void
    {
        $seconds = config('alert.queue_wait_limit');
        $format = Carbon::now()->addSeconds($seconds)->diffForHumans();
        $wait = ['total' => $seconds, 'format' => $format];

        event(new QueueAlarm('test-queue', $wait));
    }
}
