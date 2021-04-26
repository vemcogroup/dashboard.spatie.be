<?php

namespace App\Services\Gitlab;

use GrahamCampbell\GitLab\GitLabManager;

class Gitlab
{
    protected GitLabManager $gitlab;
    protected int $groupId;

    public function __construct(GitLabManager $gitlab)
    {
        $this->gitlab = $gitlab;
        $this->groupId = env('GITLAB_GROUP');

        // $this->name = 'Review';
        // $this->url = 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Ready for review';
                                        // /api/v4/groups/2529524/issues?state=opened&scope=all&per_page=1&labels=Ready%20for%20review
    }

    public function getReadyForReview()
    {
        $test = $this->gitlab->issues()->group($this->groupId, [
            'state' => 'opened',
            'scope' => 'all',
            'per_page' => 1,
            // 'labels' => 'Ready for review',
        ]);
        $bla = 1;
        // return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }

    public function getApprovedForRelease()
    {
        $test = $this->gitlab->issues()->group($this->groupId, [
            'state' => 'opened',
            'scope' => 'all',
            'per_page' => 1,
            'labels' => 'Approved for release',
        ]);
        $bla = 1;
        // return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }

    public function getReadyToDeployOnStaging()
    {
        $test = $this->gitlab->issues()->group($this->groupId, [
            'state' => 'opened',
            'scope' => 'all',
            'per_page' => 1,
            'labels' => 'Deploy on staging',
        ]);
        $bla = 1;
        // return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }

    public function getAllIssues()
    {
        $test = $this->gitlab->issues()->group($this->groupId, [
            'state' => 'opened',
            'scope' => 'all',
            'per_page' => 1,
        ]);
        $bla = 1;
        // return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }

    public function getMergeRequests()
    {/*
        $test = $this->gitlab->mergeRequests()->all(null, [
            'state' => 'opened',
            'scope' => 'all',
            'per_page' => 1,
        ]);
        $bla = 1;
*/
        //         return $this->httpClient->get($this->url)->getHeader('X-Total')[0];
    }
}
