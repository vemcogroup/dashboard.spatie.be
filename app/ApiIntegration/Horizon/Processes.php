<?php

namespace App\ApiIntegration\Horizon;

class Processes extends Horizon
{
    protected $name = 'Horizon';

    public function getValue(): string
    {
        $workers = (new Workers())->getValue();
        return $workers . '/' . $this->getContent()->processes;
    }
}
