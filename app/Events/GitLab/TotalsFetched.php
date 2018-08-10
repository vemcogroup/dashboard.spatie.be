<?php

namespace App\Events\GitLab;

use App\Events\DashboardEvent;

class TotalsFetched extends DashboardEvent
{
    /** @var int */
    public $issues;

    /** @var int */
    public $mergeRequests;

    /** @var int */
    public $finished;

    /** @var int */
    public $approved;

    /** @var int */
    public $deployed;

    public function __construct(array $totals)
    {
        foreach ($totals as $sumName => $details) {
            $this->$sumName = $details['count'];
        }
    }
}
