<?php

namespace App\Console;

use App\Console\Commands\Stats\UpdatePods;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Stats\UpdateStats;
use Spatie\VeloTile\FetchVeloStationsCommand;
use App\Console\Commands\Stats\SensorsOffline;
use App\Console\Commands\Services\GetDevServices;
use Spatie\CalendarTile\FetchCalendarEventsCommand;
use App\Tiles\TeamMember\Commands\FetchTasksCommand;
use App\Console\Commands\Services\GetDeviceServices;
use App\Console\Commands\Zendesk\FetchZendeskTickets;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use Spatie\BelgianTrainsTile\FetchBelgianTrainsCommand;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Tiles\IssueTracking\Commands\FetchIssuesCommand;
use App\Tiles\TeamMember\Commands\FetchSlackStatusCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tiles\Statistics\Commands\FetchGitHubTotalsCommand;
use App\Tiles\TeamMember\Commands\FetchCurrentTracksCommand;
use App\Tiles\Statistics\Commands\FetchPackagistTotalsCommand;
use Spatie\TimeWeatherTile\Commands\FetchOpenWeatherMapDataCommand;
use Spatie\TimeWeatherTile\Commands\FetchBuienradarForecastsCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command(FetchBelgianTrainsCommand::class)->everyMinute();
        // $schedule->command(FetchCalendarEventsCommand::class)->everyMinute();
        // $schedule->command(FetchCurrentTracksCommand::class)->everyMinute();
        // $schedule->command(FetchBuienradarForecastsCommand::class)->everyFiveMinutes();
        $schedule->command(FetchOpenWeatherMapDataCommand::class)->everyFiveMinutes();
        //$schedule->command(FetchTasksCommand::class)->everyFiveMinutes();
        // $schedule->command(FetchSlackStatusCommand::class)->everyMinute();
        // $schedule->command(FetchGitHubTotalsCommand::class)->everyThirtyMinutes();
        $schedule->command(FetchPackagistTotalsCommand::class)->hourly();
        // $schedule->command(FetchVeloStationsCommand::class)->everyMinute();


        $schedule->command(FetchIssuesCommand::class)->hourly();


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
        $commandDirectories = glob(app_path('Tiles/*'), GLOB_ONLYDIR);
        $commandDirectories[] = app_path('Console');

        collect($commandDirectories)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });
    }
}
