<?php

namespace App\Events\Stats;

use App\Events\DashboardEvent;

class StatsFetched extends DashboardEvent
{
    /** @var array */
    public $stats;

    public function __construct(array $stats)
    {
        $this->stats = $stats;
    }
}
