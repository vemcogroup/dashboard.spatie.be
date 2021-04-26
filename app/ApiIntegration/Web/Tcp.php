<?php

namespace App\ApiIntegration\Web;

use Exception;
use App\ApiIntegration\ApiIntegration;

class Tcp extends ApiIntegration
{
    protected $url;
    protected $port;
    protected $timeout = 10;

    public function __construct($url, $port='80')
    {
        $this->url = $url;
        $this->port = $port;
    }

    public function getValue()
    {
        try {
            if (!$fp = fsockopen($this->url, $this->port, $errno, $errstr, $this->timeout)) {
                return false;
            }

            fclose($fp);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
