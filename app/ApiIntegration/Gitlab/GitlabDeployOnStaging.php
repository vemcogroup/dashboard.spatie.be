<?php

namespace App\ApiIntegration\Gitlab;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class GitlabDeployOnStaging extends ApiIntegration
{

    /**
     * @var string
     */
    protected $groupId;

    /**
     * @var string
     */
    protected $url;
    protected $baseUrl;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * DynatraceProblems constructor.
     */
    public function __construct()
    {
        $this->name = 'Staging';

        $this->groupId = env('GITLAB_GROUP');
        $this->baseUrl = env('GITLAB_URL');

        $this->url = $this->baseUrl . '/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Deploy on staging';

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);
    }

    /**
     * @return int
     */
    public function getValue() : int
    {
        return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }
}