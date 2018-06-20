<?php

namespace App\ApiIntegration\Dynatrace;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class DynatraceProblems extends ApiIntegration
{
    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $url = null;

    /**
     * @var Client
     */
    protected $httpClient = null;

    /**
     * DynatraceProblems constructor.
     */
    public function __construct()
    {
        $this->name = 'Dynatrace';

        $this->id = env('DYNATRACE_ID');

        $this->url = "https://$this->id.live.dynatrace.com/api/v1/problem/status";

        $this->httpClient = new Client([
            'headers' => [
                'Authorization' => 'Api-Token ' . env('DYNATRACE_TOKEN'),
            ]
        ]);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return json_decode($this->httpClient->get($this->url)->getBody()->getContents())->result->totalOpenProblemsCount;
    }
}