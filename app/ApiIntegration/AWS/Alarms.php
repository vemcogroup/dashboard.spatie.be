<?php

namespace App\ApiIntegration\AWS;

use Aws\Result;
use Aws\CloudWatch\CloudWatchClient;
use App\ApiIntegration\ApiIntegration;

class Alarms extends ApiIntegration
{
    /**
     * @var CloudWatchClient
     */
    protected $aws;

    public function __construct()
    {
        $this->name = 'AWS';

        $this->aws = \AWS::createClient('cloudwatch');
    }

    public function getValue()
    {
        /** @var Result $result */
        $result = $this->aws->describeAlarms();
        $metricAlarms = $result->get('MetricAlarms');

        $activeAlarms = 0;

        foreach ($metricAlarms as $alarm) {
            if ($alarm['StateValue'] != 'OK') {
                $activeAlarms++;
            }
        }

        return $activeAlarms;
    }
}
