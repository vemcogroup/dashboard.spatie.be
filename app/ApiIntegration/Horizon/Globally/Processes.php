<?php

namespace App\ApiIntegration\Horizon\Globally;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;
use App\ApiIntegration\Horizon\Workers;

class Processes extends ApiIntegration
{
    protected $workers;
    protected $processes;
    protected $name = 'Horizon';

    public function __construct()
    {
        $this->httpClient = new Client();

        foreach (config('horizon.domains') as $domain) {
            $url = 'https://' .$domain . '/horizon/api/stats';
            $this->workers += (new Workers($domain))->getValue();
            $this->processes += $this->getContent($url)->processes;
        }
    }

    public function getContent($url, $asArray = false)
    {
        return  json_decode($this->httpClient->get($url)->getBody()->getContents(), $asArray);
    }

    public function getValue()
    {
        return $this->workers . 'W / ' . $this->processes . 'P';
    }
}
