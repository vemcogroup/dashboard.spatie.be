<?php

namespace App\Events\GitLab;

use App\Events\DashboardEvent;

class LabelsFetched extends DashboardEvent
{
    /** @var array */
    public $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }
}
