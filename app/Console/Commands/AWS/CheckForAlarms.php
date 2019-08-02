<?php

namespace App\Console\Commands\AWS;

use App\ApiIntegration\AWS\Alarms;
use Illuminate\Console\Command;

class CheckForAlarms extends Command
{
    protected $signature = 'aws:check-for-alarms';
    protected $description = 'Poll AWS for CloudWatch alarms';

    protected $alarms;

    public function __construct()
    {
        parent::__construct();

        $this->alarms = new Alarms();
    }

    public function handle(): void
    {
        $this->info($this->alarms->getValue());
    }
}
