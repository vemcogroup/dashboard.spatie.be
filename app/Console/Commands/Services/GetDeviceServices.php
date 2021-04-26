<?php

namespace App\Console\Commands\Services;

use Illuminate\Console\Command;
use App\Events\Services\DeviceServices;
use App\Http\Controllers\ServiceController;

class GetDeviceServices extends Command
{
    protected $signature = 'dashboard:get-device-services';

    protected $description = 'Get device services status';

    public function handle(): void
    {
        event(new DeviceServices((new ServiceController())->services));
    }
}
