<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\Dashboard\Reload;

class DashboardReload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload connected dashboards';

    public function handle() : void
    {
        event(new Reload());
    }
}
