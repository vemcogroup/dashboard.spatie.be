<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Console\Commands\Feed\ReadFeeds;
use App\Console\Commands\Stats\UpdatePods;
use App\Console\Commands\Stats\UpdateStats;
use Spatie\VeloTile\FetchVeloStationsCommand;
use App\Console\Commands\Stats\SensorsOffline;
use App\Console\Commands\Services\GetDevServices;
use Spatie\CalendarTile\FetchCalendarEventsCommand;
use App\Console\Commands\Services\GetDeviceServices;
use App\Console\Commands\Zendesk\FetchZendeskTickets;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use Spatie\BelgianTrainsTile\FetchBelgianTrainsCommand;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Tiles\TeamMember\Commands\FetchSlackStatusCommand;
use App\Tiles\Statistics\Commands\FetchGitHubTotalsCommand;
use App\Tiles\TeamMember\Commands\FetchCurrentTracksCommand;
use App\Tiles\Statistics\Commands\FetchPackagistTotalsCommand;
use Spatie\TimeWeatherTile\Commands\FetchOpenWeatherMapDataCommand;

class UpdateDashboardCommand extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle(): void
    {
        // $this->call(FetchBelgianTrainsCommand::class);
        // $this->call(FetchCurrentTracksCommand::class);
        // $this->call(FetchVeloStationsCommand::class);
        // $this->call(FetchSlackStatusCommand::class);
        // $this->call(FetchCalendarEventsCommand::class);
        //$this->call(FetchGitHubTotalsCommand::class);
        $this->call(FetchPackagistTotalsCommand::class);
        $this->call(FetchOpenWeatherMapDataCommand::class);

        $this->call(FetchGitlabTasksByLabel::class);
        $this->call(FetchGitlabMilestones::class);
        $this->call(UpdateStats::class);
        $this->call(UpdatePods::class);
        $this->call(ReadFeeds::class);
        $this->call(FetchZendeskTickets::class);
        $this->call(SensorsOffline::class);
        $this->call(GetDeviceServices::class);
        $this->call(GetDevServices::class);
    }
}
