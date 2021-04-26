<?php

namespace App\ApiIntegration\Horizon;

use Carbon\Carbon;

class Wait extends Horizon
{
    protected $queue = '';
    protected $name = 'Queue';

    public function __construct($queue)
    {
        parent::__construct();
        $this->queue = $queue;
        $this->url = 'https://l.vemcount.com/horizon/api/workload';
    }

    public function getValue()
    {
        $total = 0;
        foreach ($this->getContent(true) as $queue) {
            if ($queue['name'] === $this->queue) {
                $total += $queue['wait'];
                break;
            }
        }
        $format = Carbon::now()->addSeconds($total)->diffForHumans();

        return ['total' => $total, 'format' => $format];
    }
}
