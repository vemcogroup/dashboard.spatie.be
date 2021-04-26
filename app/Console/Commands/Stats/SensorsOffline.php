<?php

namespace App\Console\Commands\Stats;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Events\Stats\UpdateSensorsOffline;

class SensorsOffline extends Command
{
    protected $signature = 'dashboard:sensors-offline';

    protected $description = 'Update all offline';

    protected $stats = [];

    public function handle(): void
    {
        $url = 'https://l.vemcount.com/api/sensor_checker/?data={%22api_key%22:%22NA1XvfpZv0GmouJOTIh0%22}';

        event(new UpdateSensorsOffline(json_decode((new Client)->get($url)->getBody()->getContents())));
    }
}
