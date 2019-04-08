<?php

namespace App\Events\Helpdesk;

use App\Events\DashboardEvent;

class TicketsFetched extends DashboardEvent
{
    /** @var array */
    public $tickets;

    public function __construct(array $tickets)
    {
        $this->tickets = $tickets;
    }
}
