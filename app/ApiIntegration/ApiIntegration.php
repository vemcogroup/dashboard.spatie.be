<?php

namespace App\ApiIntegration;

abstract class ApiIntegration
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public abstract function getValue();
}