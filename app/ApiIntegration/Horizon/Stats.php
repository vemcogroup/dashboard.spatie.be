<?php

namespace App\ApiIntegration\Horizon;

class Stats extends Horizon
{
    protected $name = 'Stats';

    public function __construct($domain = 'vemcount.app')
    {
        parent::__construct($domain);
        $this->url = 'https://' .$this->domain . '/horizon/api/stats';
    }
}
