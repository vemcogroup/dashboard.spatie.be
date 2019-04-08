<?php

namespace App\Events\Services;

use App\Events\DashboardEvent;

class UpdateServices extends DashboardEvent
{
    /** @var array */
    public $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }
}
