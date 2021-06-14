<?php

namespace App\Events\Alarms;

class QueueAlarm
{
    public $name;
    public $wait;
    public $domain;

    public function __construct($domain, $name, $wait)
    {
        $this->domain = $domain;
        $this->name = $name;
        $this->wait = $wait;
    }
}
