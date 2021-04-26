<?php

namespace App\Console\Commands\Gitlab;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Events\GitLab\TotalsFetched;

class FetchGitlabGroupInfo extends Command
{
    protected $signature = 'dashboard:fetch-gitlab-group-info';

    protected $description = 'Fetch Gitlab group info';

    protected $resources = null;

    protected $httpClient = null;

    protected $groupId = null;

    public function handle()
    {
        $this->groupId = env('GITLAB_GROUP');
        $this->resources = new Collection();

        $this->resources->put('issues', [
            'url' => 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1'
        ]);

        $this->resources->put('finished', [
            'url' => 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Solution finished'
        ]);

        $this->resources->put('approved', [
            'url' => 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Approved for production'
        ]);

        $this->resources->put('deployed', [
            'url' => 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/issues?state=opened&scope=all&per_page=1&labels=Deployed on staging'
        ]);

        $this->resources->put('mergeRequests', [
            'url' => 'https://gitlab.com/api/v4/groups/' . $this->groupId . '/merge_requests?state=opened&scope=all&per_page=1'
        ]);

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);

        foreach ($this->resources as $type => $resource) {
            $resource['count'] = $this->httpClient->get($resource['url'])->getHeader('X-Total')[0];
            $this->resources->put($type, $resource);
        }

        event(new TotalsFetched($this->resources->all()));
    }
}
