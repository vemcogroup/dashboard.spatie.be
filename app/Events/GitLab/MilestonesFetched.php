<?php

namespace App\Events\GitLab;

use App\Events\DashboardEvent;

class MilestonesFetched extends DashboardEvent
{
    /** @var array */
    public $milestones;

    public function __construct(array $milestones)
    {
        $this->milestones = $milestones;
    }
}
