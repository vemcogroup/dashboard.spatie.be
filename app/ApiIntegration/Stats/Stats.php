<?php

namespace App\ApiIntegration\Stats;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class Stats extends ApiIntegration
{
    protected $url;
    protected $httpClient;

    public function __construct()
    {
        $this->url = 'http://10.11.10.2:81/api/stats';
        $this->httpClient = new Client();
    }

    public function getContent($asArray = false)
    {
        return  json_decode($this->httpClient->get($this->url)->getBody()->getContents(), $asArray);
    }

    public function getValue()
    {
        return 0;
    }
}
