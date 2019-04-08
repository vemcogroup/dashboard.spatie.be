<?php

namespace App\Console\Commands\Services;

use Illuminate\Console\Command;
use App\Events\Services\UpdateServices;
use App\Http\Controllers\ServiceController;

class GetServices extends Command
{
    protected $signature = 'dashboard:get-services';

    protected $description = 'Get services status';

    public function handle(): void
    {
        event(new UpdateServices((new ServiceController())->services));
    }
}
