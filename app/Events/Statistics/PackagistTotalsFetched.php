<?php

namespace App\Events\Statistics;

use App\Events\DashboardEvent;

class PackagistTotalsFetched extends DashboardEvent
{
    /** @var int */
    public $daily;

    /** @var int */
    public $monthly;

    /** @var int */
    public $total;

    public function __construct(array $totals)
    {
        $this->daily = $totals['daily'];

        $this->monthly = $totals['monthly'];

        $this->total = $totals['total'];
    }
}
