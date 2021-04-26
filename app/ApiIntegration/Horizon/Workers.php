<?php

namespace App\ApiIntegration\Horizon;

class Workers extends Horizon
{
    protected $name = 'Workers';

    public function __construct()
    {
        parent::__construct();
        $this->url = 'https://l.vemcount.com/horizon/api/masters';
    }

    public function getValue(): int
    {
        return count($this->getContent(true));
    }
}
