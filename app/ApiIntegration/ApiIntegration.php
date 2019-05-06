<?php

namespace App\ApiIntegration;

abstract class ApiIntegration
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    abstract public function getValue();
}
