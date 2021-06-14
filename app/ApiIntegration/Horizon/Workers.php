<?php

namespace App\ApiIntegration\Horizon;

class Workers extends Horizon
{
    protected $name = 'Workers';

    public function __construct($domain)
    {
        parent::__construct($domain);
        $this->url = 'https://' . $this->domain . '/horizon/api/masters';
    }

    public function getValue(): int
    {
        return count($this->getContent(true));
    }
}
