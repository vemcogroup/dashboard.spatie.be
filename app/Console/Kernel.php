<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
//        $schedule->command('dashboard:fetch-calendar-events')->everyMinute();
// $schedule->command('dashboard:fetch-current-track')->everyMinute();
        $schedule->command('dashboard:send-heartbeat')->everyMinute();
//        $schedule->command('dashboard:fetch-tasks')->everyFiveMinutes();
        //$schedule->command('dashboard:fetch-github-totals')->everyThirtyMinutes();
//        $schedule->command('dashboard:fetch-packagist-totals')->hourly();
//        $schedule->command('dashboard:fetch-npm-totals')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Components');
    }
}
