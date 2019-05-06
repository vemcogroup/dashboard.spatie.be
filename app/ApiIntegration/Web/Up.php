<?php

namespace App\ApiIntegration\Web;

use Exception;
use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class Up extends ApiIntegration
{
    protected $url;
    protected $httpClient;
    protected $expectedCode;

    public function __construct($url = '', $expectedCode = 200)
    {
        $this->url = $url;
        $this->expectedCode = $expectedCode;
        $this->httpClient = new Client();
    }

    public function getStatus()
    {
        return  $this->httpClient->get($this->url, ['allow_redirects' => false])->getStatusCode();
    }

    public function getValue()
    {
        try {
            return $this->expectedCode === $this->getStatus();
        } catch (Exception $e) {
            return false;
        }
    }
}
