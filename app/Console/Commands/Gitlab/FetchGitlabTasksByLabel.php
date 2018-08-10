<?php

namespace App\Console\Commands\Gitlab;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Events\GitLab\LabelsFetched;

class FetchGitlabTasksByLabel extends Command
{
    protected $signature = 'dashboard:fetch-gitlab-tasks-by-label';

    protected $description = 'Fetch tasks by label from Gitlab';

    protected $url = null;

    protected $httpClient = null;

    protected $projectId = null;

    protected $issues = [];

    protected $validLabels = ['To Do', 'Implementing solution'];

    public function handle() : void
    {
        $this->projectId = env('GITLAB_PROJECT');

        $this->url = 'https://gitlab.com/api/v4/projects/'.$this->projectId.'/issues?state=opened&scope=all&order_by=updated_at&per_page=100&labels=';

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);

        $parsed = [];
        foreach ($this->validLabels as $validLabel) {
            $gitlabIssues = json_decode($this->httpClient->get($this->url . $validLabel)->getBody()->getContents());
            $parsed = array_merge($parsed, $this->parseGitlabIssue($gitlabIssues));
        }

        foreach ($parsed as $issue) {
            $this->issues[$issue['label']][] = $issue;
        }

        event(new LabelsFetched($this->issues));
    }

    protected function parseGitlabIssue($gitlabIssues) : array
    {
        $issues = [];
        foreach ($gitlabIssues as $gitlabIssue) {
            $tags = [];
            $types = [];
            foreach ($gitlabIssue->labels as $label) {
                if(starts_with($label,'#')) {
                    $tags[] = $label;
                    continue;
                }
                if(starts_with($label,'/')) {
                    $types[] = $label;
                    continue;
                }
                $issues[] = [
                    'id' => $gitlabIssue->iid,
                    'title' => $gitlabIssue->title,
                    'teamMember' => collect($gitlabIssue->assignees)->map(function ($assignee) {
                        return [
                            'username' => $assignee->username,
                            'avatar' => $assignee->avatar_url,
                        ];
                    }),
                    'label' => $label,
                    'milestone' => $gitlabIssue->milestone ? $gitlabIssue->milestone->title : '',
                    'tags' => $tags,
                    'types' => $types,
                    'weight' => $gitlabIssue->weight ?? 0,
                    'time' => [
                        'estimated' => $gitlabIssue->time_stats->time_estimate,
                        'spend' => $gitlabIssue->time_stats->total_time_spent,
                    ]
                ];
            }
        }

        return $issues;
    }
}
