<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Console\Commands\Feed\ReadFeeds;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Commands\Gitlab\FetchGitlabMilestones;
use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Console\Components\InternetConnection\SendHeartbeat;

class UpdateDashboard extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle(): void
    {
        $this->call(UpdateStats::class);
        $this->call(FetchGitlabTasksByLabel::class);
        $this->call(FetchGitlabMilestones::class);
        $this->call(SendHeartbeat::class);
        $this->call(ReadFeeds::class);
    }
}
