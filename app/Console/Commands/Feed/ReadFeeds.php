<?php

namespace App\Console\Commands\Feed;

use Illuminate\Console\Command;
use App\Events\Feeds\FeedsFetched;

class ReadFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:read-feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read all feeds';

    protected $urls = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->urls['AWS'] = 'https://aws.amazon.com/new/feed/';
        $this->urls['PHP'] = 'http://php.net/feed.atom';

    }

    public function handle() : void
    {
        $feeds = [];

        foreach ($this->urls as $name => $url) {
            $feeds = array_merge($feeds, $this->parseUrl($name, $url));
        }

        event(new FeedsFetched(count($feeds) > 20 ? array_slice($feeds, 0, 20): $feeds));
    }

    public function parseUrl($name, $url)
    {
        $feeds = [];

        foreach(\Feeds::make($url)->get_items() as $item) {
            $feeds[] = [
                'type' => $name,
                'date' => $item->get_date(),
                'title' => $item->get_title(),
            ];
        }

        return $feeds;
    }
}
