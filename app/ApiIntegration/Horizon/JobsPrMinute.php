<?php

namespace App\ApiIntegration\Horizon;

class JobsPrMinute extends Horizon
{
    protected $name = 'Jobs per min';

    public function getValue(): int
    {
        return $this->getContent()->jobsPerMinute;
    }
}
