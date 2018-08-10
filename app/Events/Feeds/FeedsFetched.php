<?php

namespace App\Events\Feeds;

use App\Events\DashboardEvent;

class FeedsFetched extends DashboardEvent
{
    /** @var array */
    public $feeds;

    public function __construct(array $feeds)
    {
        $this->feeds = $feeds;
    }
}
