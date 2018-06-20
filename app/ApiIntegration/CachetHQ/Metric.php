<?php

namespace App\ApiIntegration\CachetHQ;

use GuzzleHttp\Client;
use App\ApiIntegration\ApiIntegration;

class Metric extends ApiIntegration
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $url;

    public function __construct(int $metric)
    {
        $this->name = 'Cachet';

        $this->url = env('CACHETHQ_URL') . '/metrics/' . $metric;

        $this->httpClient = new Client([
            'headers' => [
                'X-Cachet-Token' => env('CACHETHQ_TOKEN'),
            ]
        ]);
    }


    public function getValue()
    {
        $last = array_values(array_splice(json_decode($this->httpClient->get($this->url)->getBody()->getContents(), true)['data']['items'], -2));

        if ($last[1] === 0) {
            $result = $last[0];
        } else {
            $result = $last[1];
        }

        return (int)$result;
    }
}
