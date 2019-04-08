<?php

namespace App\Console;

use App\Console\Commands\Feed\ReadFeeds;
use App\Console\Commands\Services\GetServices;
use App\Console\Commands\Stats\SensorsOffline;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Commands\Zendesk\FetchZendeskTickets;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Console\Components\Dashboard\SendHeartbeatCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Components\Statistics\FetchPackagistTotalsCommand;

class Kernel extends ConsoleKernel
{
    public function commands()
    {
        $commandDirectries = glob(app_path('Console/*'), GLOB_ONLYDIR);
        $commandDirectries[] = app_path('Console');

        collect($commandDirectries)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });

        /*$commandDirectries = glob(app_path('Console/Commands/*'), GLOB_ONLYDIR);
        $commandDirectries[] = app_path('Console');

        collect($commandDirectries)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });*/
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SendHeartbeatCommand::class)->everyMinute();
        //$schedule->command(DetermineAppearanceCommand::class)->everyMinute();
        $schedule->command(FetchPackagistTotalsCommand::class)->everyFiveMinutes();
        $schedule->command(FetchGitlabTasksByLabel::class)->everyFiveMinutes();
        $schedule->command(FetchGitlabMilestones::class)->everyFiveMinutes();
        $schedule->command(UpdateStats::class)->everyFiveMinutes();
        $schedule->command(ReadFeeds::class)->everyFiveMinutes();
        $schedule->command(FetchZendeskTickets::class)->everyFiveMinutes();
        $schedule->command(SensorsOffline::class)->everyFiveMinutes();
        $schedule->command(GetServices::class)->everyFiveMinutes();
        //$schedule->command('websockets:clean')->daily();
    }
}
