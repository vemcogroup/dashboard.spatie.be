<?php

namespace App\ApiIntegration\Stats;

class ActiveSensors extends Stats
{
    protected $name = 'Sensors';

    public function getValue()
    {
        $this->url .= '/sensors/active';
        $active = $this->getContent()->active;

        if ($active > 10000000) { // 10 Mill
            return number_format($active / 100000) . 'M';
        }

        if ($active > 100000) { // 100 K
            return number_format($active / 1000) . 'K';
        }

        return $active;
    }
}
