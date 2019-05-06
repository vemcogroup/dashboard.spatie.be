<?php

namespace App\Events\Services;

use App\Events\DashboardEvent;

class DeviceServices extends DashboardEvent
{
    /** @var array */
    public $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }
}
