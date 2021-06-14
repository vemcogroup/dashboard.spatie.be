<?php

namespace App\ApiIntegration\Horizon;

class Processes extends Stats
{
    protected $name = 'Horizon';
    protected $includeWorkers;

    public function __construct($domain, $includeWorkers = false)
    {
        parent::__construct($domain);

        $this->includeWorkers = $includeWorkers;
    }

    public function getValue()
    {
        if ($this->includeWorkers === false) {
            return $this->getContent()->processes;
        }

        $workers = (new Workers($this->domain))->getValue();
        return $workers . 'W / ' . $this->getContent()->processes . 'P';
    }
}
