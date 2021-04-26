<?php

namespace App\ApiIntegration\Horizon;

class Processes extends Horizon
{
    protected $name = 'Horizon';
    protected $includeWorkers;

    public function __construct($includeWorkers = false)
    {
        parent::__construct();

        $this->includeWorkers = $includeWorkers;
    }

    public function getValue()
    {
        if ($this->includeWorkers === false) {
            return $this->getContent()->processes;
        }


        $workers = (new Workers())->getValue();
        return $workers . 'W / ' . $this->getContent()->processes . 'P';
    }
}
