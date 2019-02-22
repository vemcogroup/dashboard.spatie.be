<?php

namespace App\Console\Commands\CachetHQ;

use App\ApiIntegration\CachetHQ\Metric;
use Illuminate\Console\Command;

class CheckMetric extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cachethq:metric {metric}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll CachetHQ for a given metric';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $metric = new Metric(env('CACHETHQ_METRIC'));

        $this->info($metric->getValue());

        return true;
    }
}
