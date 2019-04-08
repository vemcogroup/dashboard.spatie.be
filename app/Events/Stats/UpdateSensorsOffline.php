<?php

namespace App\Events\Stats;

use App\Events\DashboardEvent;

class UpdateSensorsOffline extends DashboardEvent
{
    /** @var array */
    public $sensors;

    public function __construct(array $sensors)
    {
        $this->sensors = $sensors;
    }
}
