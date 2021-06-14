<?php

namespace App\ApiIntegration\Horizon;

class Queue extends Horizon
{
    protected $name = 'Queue';

    public function __construct($domain)
    {
        parent::__construct($domain);
        $this->url = 'https://' . $this->domain . '/horizon/api/workload';
    }

    public function getValue()
    {
        $total = 0;
        foreach ($this->getContent(true) as $queue) {
            $total += $queue['length'];
        }
        $format = $total;

        if ($total > 10000000) { // 10 Mill
            $format = number_format($total / 100000) . 'M';
        }

        if ($total > 100000) { // 100 K
            $format = number_format($total / 1000) . 'K';
        }

        return ['total' => $total, 'format' => $format];
    }
}
