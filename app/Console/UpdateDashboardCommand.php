<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Console\Commands\Feed\ReadFeeds;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Console\Components\Dashboard\SendHeartbeatCommand;
use App\Console\Components\Statistics\FetchPackagistTotalsCommand;

class UpdateDashboardCommand extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle(): void
    {
        $this->call(SendHeartbeatCommand::class);
        $this->call(UpdateStats::class);
        $this->call(FetchGitlabTasksByLabel::class);
        $this->call(ReadFeeds::class);
        $this->call(FetchGitlabMilestones::class);
        $this->call(FetchPackagistTotalsCommand::class);
    }
}
