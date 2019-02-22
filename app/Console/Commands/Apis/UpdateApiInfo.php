<?php

namespace App\Console\Commands\Apis;

use App\ApiIntegration\CachetHQ\Metric;
use Illuminate\Console\Command;
use App\ApiIntegration\AWS\Alarms;
use App\Events\Apis\StatusFetched;
use App\ApiIntegration\ApiIntegration;
use App\ApiIntegration\Dynatrace\DynatraceProblems;

class UpdateApiInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apis:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all apis info';

    /**
     * @var ApiIntegration[]
     */
    protected $apis = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->apis[] = new DynatraceProblems();
        $this->apis[] = new Alarms();
        $this->apis[] = new Metric(env('CACHETHQ_METRIC'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $status = [];

        foreach ($this->apis as $api)
        {
            $status[] = [
                'name' => $api->getName(),
                'value' => $api->getValue(),
            ];
        }

        event(new StatusFetched($status));
    }
}
