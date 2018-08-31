<?php

namespace App\Console;

use App\Console\Commands\Feed\ReadFeeds;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Components\InternetConnection\SendHeartbeat;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendHeartbeat::class)->everyMinute();
        $schedule->command(UpdateStats::class)->everyFiveMinutes();
        $schedule->command(FetchGitlabTasksByLabel::class)->everyFiveMinutes();
        $schedule->command(ReadFeeds::class)->everyFiveMinutes();
        $schedule->command(FetchGitlabMilestones::class)->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Components');
        $this->load(__DIR__ . '/Commands');
    }
}
