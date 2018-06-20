<?php

namespace App\Events\Apis;

use App\Events\DashboardEvent;

class StatusFetched extends DashboardEvent
{
    /** @var array */
    public $status;

    public function __construct(array $status)
    {
        $this->status = $status;
    }
}
