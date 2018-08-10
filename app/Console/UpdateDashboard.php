<?php

namespace App\Console;

use App\Console\Commands\Gitlab\FetchGitlabTasksByLabel;
use App\Console\Commands\Stats\UpdateStats;
use App\Console\Components\InternetConnection\SendHeartbeat;
use Illuminate\Console\Command;

class UpdateDashboard extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle() : void
    {
        $this->call(UpdateStats::class);
        $this->call(FetchGitlabTasksByLabel::class);
        $this->call(SendHeartbeat::class);
    }
}
