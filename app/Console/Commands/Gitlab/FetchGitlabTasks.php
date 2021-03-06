<?php

namespace App\Console\Commands\Gitlab;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Events\TeamMember\TasksFetched;

class FetchGitlabTasks extends Command
{
    protected $signature = 'dashboard:fetch-gitlab-tasks';
    protected $description = 'Fetch team members tasks from Gitlab';

    protected $url;
    protected $baseUrl;
    protected $httpClient;
    protected $projectId;
    protected $userIds = [];
    protected $issues = [];

    public function handle(): void
    {
        $this->projectId = env('GITLAB_PROJECT');
        $this->baseUrl = env('GITLAB_URL');

        $this->url = $this->baseUrl . '/api/v4/projects/$this->projectId/issues?state=opened&scope=all&order_by=updated_at&assignee_id=';

        $this->userIds = \explode(',', env('GITLAB_USER_IDS'));

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);

        $parsed = [];

        foreach ($this->userIds as $userId) {
            $gitlabIssues = json_decode($this->httpClient->get($this->url . $userId)->getBody()->getContents());

            foreach ($gitlabIssues as $gitlabIssue) {
                $parsed = array_merge(
                    $parsed,
                    $this->parseGitlabIssue($gitlabIssue)
                );
            }
        }

        foreach ($parsed as $issue) {
            $this->issues[$issue['teamMember']][] = $issue;
        }

        event(new TasksFetched($this->issues));
    }

    protected function parseGitlabIssue($gitlabIssue)
    {
        $issues = [];

        foreach ($gitlabIssue->assignees as $assignee) {
            $issues[] = [
                'id' => $gitlabIssue->iid,
                'title' => $gitlabIssue->title,
                'teamMember' => $assignee->username,
            ];
        }

        return $issues;
    }
}
