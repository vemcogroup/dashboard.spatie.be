<?php

namespace App\ApiIntegration\Horizon\Globally;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class JobsPrHour extends ApiIntegration
{
    protected $jobs;
    protected $name = 'Jobs';

    public function __construct()
    {
        $this->httpClient = new Client();

        foreach (config('horizon.domains') as $domain) {
            $url = 'https://' .$domain . '/horizon/api/stats';
            $this->jobs += $this->getContent($url)->recentJobs;
        }
    }

    public function getContent($url, $asArray = false)
    {
        return  json_decode($this->httpClient->get($url)->getBody()->getContents(), $asArray);
    }

    public function getValue()
    {
        $jobs = $this->jobs;

        if ($jobs > 10000000) { // 10 Mill
            return number_format($jobs / 100000) . 'M';
        }

        if ($jobs > 100000) { // 100 K
            return number_format($jobs / 1000) . 'K';
        }

        return $jobs;
    }
}
