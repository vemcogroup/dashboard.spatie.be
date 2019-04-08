<?php

namespace App\SystemServiceInteraction;

class Wait implements Instruction
{
    public $duration;

    /**
     * Wait constructor.
     * @param $duration
     */
    public function __construct($duration)
    {
        $this->duration = $duration;
    }

    public function execute()
    {
        return "sleep $this->duration";
    }
}
