<?php

namespace App\Console\Commands\Bugsnag;

use App\ApiIntegration\Bugsnag\BugsnagProblems;
use Illuminate\Console\Command;

class CheckForProblems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugsnag:check-for-problems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll Bugsnag for problems';

    protected $bugsnagProblems;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->bugsnagProblems = new BugsnagProblems();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->bugsnagProblems->getValue());

        return true;
    }
}
