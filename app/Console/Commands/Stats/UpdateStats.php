<?php

namespace App\Console\Commands\Stats;

use Illuminate\Console\Command;
use App\Events\Stats\StatsFetched;
use App\ApiIntegration\Stats\ActiveUsers;
use App\ApiIntegration\Stats\ActiveSensors;
use App\ApiIntegration\Gitlab\GitlabMergeRequests;
use App\ApiIntegration\Horizon\Globally\Processes;
use App\ApiIntegration\Horizon\Globally\JobsPrHour;
use App\ApiIntegration\Gitlab\GitlabReadyForReview;

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
                new Processes(),
                new JobsPrHour(),
                new ActiveSensors(),
                new ActiveUsers(),
            ],
        ];

        $this->stats[] = [
            'label' => 'GitLab',
            'showTitle' => true,
            'showEmpty' => false,
            'items' => [
                new GitlabReadyForReview(),
                new GitlabMergeRequests(),
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
