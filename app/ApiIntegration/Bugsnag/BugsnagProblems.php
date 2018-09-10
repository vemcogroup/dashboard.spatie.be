<?php

namespace App\ApiIntegration\Bugsnag;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class BugsnagProblems extends ApiIntegration
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Client
     */
    protected $httpClient;

    public function __construct()
    {
        $this->name = 'Bugsnag';
        $this->id = env('BUGSNAG_PROJECT_ID');
        $this->url = "https://api.bugsnag.com/projects/$this->id/errors?per_page=100&filters[error.status][][type]=eq&filters[error.status][][value]=open";

        $this->httpClient = new Client([
            'headers' => [
                'Authorization' => 'token ' . env('BUGSNAG_TOKEN'),
                'X-Version' => 2,
            ]
        ]);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        $response = json_decode($this->httpClient->get($this->url)->getBody()->getContents());
        return count($response);
    }
}