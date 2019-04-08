<?php

namespace App\SystemServiceInteraction;

class SystemCommand implements Instruction
{
    private $action;

    /**
     * SystemCommand constructor.
     * @param $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    public function execute()
    {
        return $this->action;
    }
}
