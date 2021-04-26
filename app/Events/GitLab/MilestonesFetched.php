<?php

namespace App\Events\GitLab;

class MilestonesFetched
{
    /** @var array */
    public $milestones;

    public function __construct(array $milestones)
    {
        $this->milestones = $milestones;
    }
}
