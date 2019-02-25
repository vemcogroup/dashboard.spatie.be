<?php

namespace App\Console\Components\Twitter;

use App\Events\Twitter\Mentioned;
use Illuminate\Console\Command;
use Spatie\LaravelTwitterStreamingApi\TwitterStreamingApi;

class ListenForMentionsCommand extends Command
{
    protected $signature = 'dashboard:listen-twitter-mentions';

    protected $description = 'Listen for mentions on Twitter';

    public function handle()
    {
        $this->info('Listening for mentions...');

        app(TwitterStreamingApi::class)
            ->publicStream()
            ->whenTweets([
                629707694, // 'vemcount',
                509273832, // 'laravelnews',
                1497912571, // 'laravel',
                101624176, // 'steveschoger',
                716933677, // 'adamwathan',
                261648371, // 'themsaid',
                97178022, // 'freekmurze',
                28870687, // 'taylorotwell',
                18469707, // 'php_net',
                1537028058, // 'official_php'
                115180931, // 'phpstorm'
            ], function () {
            })
            ->whenFrom([], function () {
            })
            ->whenHears([
                'vemcount',
                '@vemcount',
                'vemcogroup',
                '@vemcogroup',
            ], function (array $tweetProperties) {
                event(new Mentioned($tweetProperties));
            })
            ->startListening();
    }
}
