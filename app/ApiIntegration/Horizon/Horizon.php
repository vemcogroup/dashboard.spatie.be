<?php

namespace App\ApiIntegration\Horizon;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class Horizon extends ApiIntegration
{
    protected $url;
    protected $httpClient;

    public function __construct()
    {
        $this->url = 'https://l.vemcount.com/horizon/api/stats';
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
