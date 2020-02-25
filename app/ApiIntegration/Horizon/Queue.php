<?php

namespace App\ApiIntegration\Horizon;

class Queue extends Horizon
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
            $total += $queue['length'];
        }

        if ($total > 10000000) { // 10 Mill
            return number_format($total / 100000) . 'M';
        }

        if ($total > 100000) { // 100 K
            return number_format($total / 1000) . 'K';
        }

        return $total;
    }
}
