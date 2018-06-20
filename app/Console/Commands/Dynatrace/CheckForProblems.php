<?php

namespace App\Console\Commands\Dynatrace;

use Illuminate\Console\Command;
use App\ApiIntegration\Dynatrace\DynatraceProblems;

class CheckForProblems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynatrace:check-for-problems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll Dynatrace for problems';

    /**
     * @var DynatraceProblems|null
     */
    protected $dynatraceProblems = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->dynatraceProblems = new DynatraceProblems();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->dynatraceProblems->getValue());

        return true;
    }
}
