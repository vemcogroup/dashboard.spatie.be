<?php

namespace App\ApiIntegration\Horizon;

class JobsPrMinute extends Stats
{
    protected $name = 'Jobs per min';

    public function getValue(): int
    {
        return $this->getContent()->jobsPerMinute;
    }
}
