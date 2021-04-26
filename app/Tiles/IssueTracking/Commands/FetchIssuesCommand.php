<?php

namespace App\Tiles\IssueTracking\Commands;

use Illuminate\Console\Command;
use App\Services\Gitlab\Gitlab;
use Illuminate\Support\Collection;
use App\Tiles\Statistics\IssueTrackingStore;
use MarkWalet\Packagist\Facades\Packagist;

class FetchIssuesCommand extends Command
{
    protected $signature = 'dashboard:fetch-issues';

    public function handle(Gitlab $gitlab): void
    {
        $this->info('Fetching issues...');

        $gitlab->getAllIssues();

        $gitlab->getReadyForReview()
            ->each(function($issue){
                $todo = 1;
                //IssueTrackingStore::find();
            });

        $this->info('All done!');
    }
}
