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
    protected $allowRedirects;

    public function __construct($url = '', $allowRedirects = true, $expectedCode = 200)
    {
        $this->url = $url;
        $this->expectedCode = $expectedCode;
        $this->allowRedirects = $allowRedirects;
        $this->httpClient = new Client();
    }

    public function getStatus()
    {
        return  $this->httpClient->get($this->url, ['allow_redirects' => $this->allowRedirects])->getStatusCode();
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
