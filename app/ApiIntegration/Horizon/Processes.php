<?php

namespace App\ApiIntegration\Horizon;

class Processes extends Horizon
{
    protected $name = 'Horizon';

    public function getValue(): int
    {
        return $this->getContent()->processes;
    }
}
