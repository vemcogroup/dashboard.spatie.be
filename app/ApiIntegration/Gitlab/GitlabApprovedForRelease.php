<?php

namespace App\ApiIntegration\Gitlab;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class GitlabApprovedForRelease extends ApiIntegration
{

    /**
     * @var string
     */
    protected $groupId;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * DynatraceProblems constructor.
     */
    public function __construct()
    {
        $this->name = 'Production';

        $this->groupId = env('GITLAB_GROUP');

        $this->url = 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Approved for release';

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
