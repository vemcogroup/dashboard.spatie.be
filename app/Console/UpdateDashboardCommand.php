<?php

namespace App\Console;

use Illuminate\Console\Command;

class UpdateDashboardCommand extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle(): void
    {
        $this->call('dashboard:send-heartbeat');
        $this->call('dashboard:fetch-packagist-totals');
        $this->call('dashboard:fetch-gitlab-tasks-by-label');
        $this->call('dashboard:fetch-gitlab-milestones');
        $this->call('dashboard:update-stats');
        $this->call('dashboard:read-feeds');
        $this->call('dashboard:fetch-zendesk-tickets');
        $this->call('dashboard:sensors-offline');
        $this->call('dashboard:get-device-services');
        $this->call('dashboard:get-dev-services');
    }
}
