<?php

namespace App\ApiIntegration\Horizon;

class JobsPrHour extends Stats
{
    protected $name = 'Jobs';

    public function getValue()
    {
        $jobs = $this->getContent()->recentJobs;

        if ($jobs > 10000000) { // 10 Mill
            return number_format($jobs / 100000) . 'M';
        }

        if ($jobs > 100000) { // 100 K
            return number_format($jobs / 1000) . 'K';
        }

        return $jobs;
    }
}
