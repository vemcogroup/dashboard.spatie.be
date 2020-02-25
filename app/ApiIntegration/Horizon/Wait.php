<?php

namespace App\ApiIntegration\Horizon;

use Carbon\Carbon;

class Wait extends Horizon
{
    protected $name = 'Queue';

    public function __construct()
    {
        parent::__construct();
        $this->url = 'https://l.vemcount.com/horizon/api/workload';
    }

    public function getValue()
    {
        $total = 0;
        foreach ($this->getContent(true) as $queue) {
            $total += $queue['wait'];
        }
        $format = Carbon::now()->addSeconds($total)->diffForHumans();

        return ['total' => $total, 'format' => $format];
    }
}
