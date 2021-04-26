<?php

namespace App\Events\GitLab;

class TotalsFetched
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
