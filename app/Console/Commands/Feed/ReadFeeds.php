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

    protected $limitPrUrl = 3;

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
        $this->urls['LARAVEL NEWS'] = 'https://feed.laravel-news.com/';
    }

    public function handle() : void
    {
        $feeds = [];

        foreach ($this->urls as $name => $url) {
            $feeds = array_merge($feeds, $this->parseUrl($name, $url));
        }

        event(new FeedsFetched($feeds));
    }

    public function parseUrl($name, $url)
    {
        $feeds = [];
        $feedCount = 0;

        foreach(\Feeds::make($url)->get_items() as $item) {

            if(++$feedCount > $this->limitPrUrl) {
                break;
            }

            $feeds[] = [
                'type' => $name,
                'date' => $item->get_date(),
                'title' => $item->get_title(),
            ];

        }

        return $feeds;
    }
}
