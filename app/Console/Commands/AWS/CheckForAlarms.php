<?php

namespace App\Console\Commands\AWS;

use App\ApiIntegration\AWS\Alarms;
use Illuminate\Console\Command;

class CheckForAlarms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:check-for-alarms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll AWS for CloudWatch alarms';

    protected $alarms = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->alarms = new Alarms();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->alarms->getValue());
    }
}
