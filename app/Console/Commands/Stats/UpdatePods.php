<?php

namespace App\Console\Commands\Stats;

use App\ApiIntegration\K8\Pods;
use Illuminate\Console\Command;
use App\ApiIntegration\K8\Nodes;
use App\Events\Stats\PodsFetched;

class UpdatePods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:update-pods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all pods';

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
                new Nodes(),
                new Pods('api'),
                new Pods('dashboard'),
                new Pods('sensorparser'),
                new Pods('frontend'),
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

        event(new PodsFetched($stats));
    }
}
