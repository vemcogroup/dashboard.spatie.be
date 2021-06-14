<?php

namespace App\ApiIntegration\Horizon;

use Carbon\Carbon;

class Wait extends Horizon
{
    protected $queue = '';
    protected $name = 'Queue';

    public function __construct($domain, $queue)
    {
        parent::__construct($domain);
        $this->queue = $queue;
        $this->url = 'https://' . $this->domain . '/horizon/api/workload';
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
