<?php

namespace App\Console\Commands\Gitlab;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Events\GitLab\MilestonesFetched;

class FetchGitlabMilestones extends Command
{
    protected $signature = 'dashboard:fetch-gitlab-milestones';

    protected $description = 'Fetch milestones from Gitlab';

    protected $url;

    protected $httpClient;

    protected $projectId;

    protected $milestones = [];

    public function handle(): void
    {
        $this->projectId = env('GITLAB_PROJECT');

        $this->url = 'https://gitlab.com/api/v4/projects/' . $this->projectId . '/milestones?state=active';

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);

        $milestones = $this->parseGitlabMilestone(json_decode($this->httpClient->get($this->url)->getBody()->getContents()));

        event(new MilestonesFetched($milestones));
    }

    protected function fetchMilestoneIssues($milestoneId)
    {
        $this->url = 'https://gitlab.com/api/v4/projects/' . $this->projectId . '/milestones/' . $milestoneId . '/issues';

        $this->httpClient = new Client([
            'headers' => [
                'PRIVATE-TOKEN' => env('GITLAB_TOKEN'),
            ]
        ]);

        $issues = [
            'active' => 0,
            'closed' => 0,
            'total' => 0,
            'bugs' => 0,
            'percent' => 0,
        ];

        foreach (json_decode($this->httpClient->get($this->url)->getBody()->getContents()) as $issue) {

            ++$issues['total'];
            $isBug = false;

            if ($issue->state !== 'closed') {
                foreach ($issue->labels as $label) {
                    if ($label === '/bug') {
                        $isBug = true;
                        ++$issues['bugs'];
                        continue;
                    }
                }
            }

            if ($issue->state === 'closed' || $isBug) {
                ++$issues['closed'];
            } else {
                ++$issues['active'];
            }

        }

        if ($issues['total']) {
            $issues['percent'] = number_format($issues['closed'] / $issues['total'] * 100, 1);
        }

        return $issues;
    }

    protected function parseGitlabMilestone($gitlabMilestones): array
    {
        $milestones = [];
        foreach ($gitlabMilestones as $gitlabMilestone) {

            if (!$gitlabMilestone->due_date) {
                continue;
            }

            $milestones[] = [
                'id' => $gitlabMilestone->iid,
                'title' => $gitlabMilestone->title,
                'color' => $this->findMilestoneColor($gitlabMilestone),
                'dueDate' => $gitlabMilestone->due_date,
                'issues' => $this->fetchMilestoneIssues($gitlabMilestone->id),
                /*'teamMember' => collect($gitlabMilestone->assignees)->map(function ($assignee) {
                    return [
                        'username' => $assignee->username,
                        'avatar' => $assignee->avatar_url,
                    ];
                }),*/
                /*'time' => [
                    'estimated' => $gitlabMilestone->time_stats->time_estimate,
                    'spend' => $gitlabMilestone->time_stats->total_time_spent,
                ]*/
            ];
        }

        return $milestones;
    }

    protected function findMilestoneColor($milestone)
    {
        if ($text = strstr($milestone->description, '#color:')) {
            return '#' . substr($text, 7, 6);
        }

        return '#8B63B7';
    }
}
