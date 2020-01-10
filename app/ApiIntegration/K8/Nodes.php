<?php

namespace App\ApiIntegration\K8;

use Maclof\Kubernetes\Client;
use App\ApiIntegration\ApiIntegration;

class Nodes extends ApiIntegration
{
    /** @var Client $client */
    protected $client;

    public function __construct()
    {
        $this->name = 'Nodes';

        $this->client = new Client([
            'master' => config('k8.master'),
            'ca_cert' => config('k8.ca_cert'),
            'token' => config('k8.token'),
            'namespace' => config('k8.namespace'),
        ]);
    }

    public function getValue()
    {
        $nodes = $this->client->nodes()->find();

        return $nodes->count();
    }
}
