<?php

namespace App\Console\Components\Twitter;

use Illuminate\Console\Command;
use App\Events\Twitter\Mentioned;
use Spatie\LaravelTwitterStreamingApi\TwitterStreamingApi;

class ListenForMentions extends Command
{
    protected $signature = 'dashboard:listen-twitter-mentions';

    protected $description = 'Listen for mentions on Twitter';

    public function handle(): void
    {
        $this->info('Listening for mentions...');

        app(TwitterStreamingApi::class)
            ->publicStream()
            ->whenTweets([
                '@vemcount',
                '@laravelnews',
                '@laravel',
                '@steveschoger',
                '@adamwathan',
                '@themsaid',
                '@freekmurze',
                '@taylorotwell',
                '@php_net',
                '@phpstorm',
                '@danijel_k',
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
