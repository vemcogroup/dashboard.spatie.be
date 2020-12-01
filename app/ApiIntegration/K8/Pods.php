<?php

namespace App\ApiIntegration\K8;

use Maclof\Kubernetes\Client;
use App\ApiIntegration\ApiIntegration;

class Pods extends ApiIntegration
{
    /** @var Client $client */
    protected $client;
    protected $app_name;
    protected $pods = ['vemcount', 'dashboard', 'api', 'sensorparser'];

    public function __construct($app_name='')
    {
        $this->name = $app_name ? ucfirst($app_name) : 'Pods';
        $this->app_name = $app_name;

        $this->client = new Client([
            'master' => config('k8.master'),
            'ca_cert' => config('k8.ca_cert'),
            'token' => config('k8.token'),
            'namespace' => config('k8.namespace'),
        ]);
    }

    public function getValue()
    {
        $result = [];
        foreach ($this->pods as $pod) {
            $value = $this->client->pods()->setLabelSelector([
                'app' => $pod,
            ])->find();
            $result[$pod] = $value ? $value->count() : 0;
        }

        return implode(' / ', $result);
    }
}
