<?php

namespace App\Console\Commands\Stats;

use Illuminate\Console\Command;
use App\Events\Stats\StatsFetched;
use App\ApiIntegration\Horizon\Workers;
use App\ApiIntegration\CachetHQ\Metric;
use App\ApiIntegration\Horizon\Processes;
use App\ApiIntegration\Horizon\JobsPrHour;
use App\ApiIntegration\Gitlab\GitlabIssues;
use App\ApiIntegration\Bugsnag\BugsnagProblems;
use App\ApiIntegration\Gitlab\GitlabMergeRequests;
use App\ApiIntegration\Gitlab\GitlabDeployOnStaging;
use App\ApiIntegration\Gitlab\GitlabSolutionFinished;
use App\ApiIntegration\Gitlab\GitlabApprovedForProduction;

class UpdateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all stats';

    protected $stats = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->stats[] = [
            'label' => 'Status',
            'showTitle' => true,
            'showEmpty' => false,
            'items' => [
                new BugsnagProblems(),
                new Processes(true),
                new JobsPrHour(),
                //new GitlabIssues(),
                new Metric(env('CACHETHQ_METRIC')),
            ],
        ];

        $this->stats[] = [
            'label' => 'GitLab',
            'showTitle' => true,
            'showEmpty' => false,
            'items' => [
                new GitlabMergeRequests(),
            ],
        ];

        $this->stats[] = [
            'label' => 'Ready for',
            'showTitle' => true,
            'showEmpty' => false,
            'items' => [
                new GitlabApprovedForProduction(),
                new GitlabSolutionFinished(),
                new GitlabDeployOnStaging(),
            ],
        ];
    }

    public function handle(): void
    {
        $stats = [];

        foreach ($this->stats as $index => $group) {
            $stats[$index] = [
                'label' => $group['label'],
                'showTitle' => $group['showTitle'],
                'stats' => [],
            ];
            foreach ($group['items'] as $stat) {
                $value = $stat->getValue();
                if ($group['showEmpty'] || $value > 0) {
                    $stats[$index]['stats'][] = [
                        'name' => $stat->getName(),
                        'value' => $value,
                    ];
                }
            }
        }

        event(new StatsFetched($stats));
    }
}
