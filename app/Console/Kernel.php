<?php

namespace App\Console;

use App\Console\Commands\Stats\UpdatePods;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Commands\Stats\SensorsOffline;
use App\Console\Commands\Services\GetDevServices;
use App\Console\Commands\Services\GetDeviceServices;
use App\Console\Commands\Zendesk\FetchZendeskTickets;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Console\Components\Dashboard\SendHeartbeatCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Components\Statistics\FetchPackagistTotalsCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendHeartbeatCommand::class)->everyMinute();
        $schedule->command(FetchPackagistTotalsCommand::class)->hourly();
        $schedule->command(FetchGitlabTasksByLabel::class)->everyFiveMinutes();
        $schedule->command(FetchGitlabMilestones::class)->everyFiveMinutes();
        $schedule->command(UpdateStats::class)->everyMinute();
        $schedule->command(UpdatePods::class)->everyMinute();
        $schedule->command(FetchZendeskTickets::class)->everyMinute();
        $schedule->command(SensorsOffline::class)->everyMinute();
        $schedule->command(GetDeviceServices::class)->everyFiveMinutes();
        $schedule->command(GetDevServices::class)->everyMinute();
    }

    public function commands(): void
    {
        $commandDirectries = glob(app_path('Console/*'), GLOB_ONLYDIR);
        $commandDirectries[] = app_path('Console');

        collect($commandDirectries)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });
    }
}
