<?php

namespace App\Events\Stats;

use App\Events\DashboardEvent;

class PodsFetched extends DashboardEvent
{
    /** @var array */
    public $stats;

    public function __construct(array $stats)
    {
        $this->stats = $stats;
    }
}
