<?php

namespace App\Events\Alarms;

class QueueAlarm
{
    public $name;
    public $wait;

    public function __construct($name, $wait)
    {
        $this->name = $name;
        $this->wait = $wait;
    }
}
