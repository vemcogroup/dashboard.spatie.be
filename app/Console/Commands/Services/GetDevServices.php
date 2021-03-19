<?php

namespace App\Console\Commands\Services;

use App\ApiIntegration\Web\Up;
use App\ApiIntegration\Web\Ftp;
use App\ApiIntegration\Web\Tcp;
use App\ApiIntegration\Web\Udp;
use Illuminate\Console\Command;
use App\Events\Alarms\QueueAlarm;
use App\ApiIntegration\AWS\Alarms;
use App\ApiIntegration\Horizon\Wait;
use App\Events\Services\DevServices;
use App\ApiIntegration\Horizon\Queue;
use App\ApiIntegration\Horizon\Processes;
use App\ApiIntegration\Web\CertificateStatus;

class GetDevServices extends Command
{
    protected $signature = 'dashboard:get-dev-services';

    protected $description = 'Get dev services status';
    protected $services = [];

    public function handle(): void
    {
        try {
            $aws = (new Alarms)->getValue();
        } catch (\Exception $e) {
            $aws = 9999;
        }
        try {
            $horizon = (new Processes)->getValue();
        } catch (\Exception $e) {
            $horizon = 0;
        }
        try {
            $queue = (new Queue)->getValue();
        } catch (\Exception $e) {
            $queue = ['total' => 999999, 'format' => 999999];
        }
        foreach (['default', 'metric-data', 'realtime'] as $name) {
            try {
                $wait[$name] = (new Wait($name))->getValue();
            } catch (\Exception $e) {
                $wait[$name] = ['total' => 999999, 'format' => 999999];
            }
            if ($wait[$name]['total'] > config('alert.queue_wait_limit')) {
                event(new QueueAlarm($name, $wait[$name]));
            }
        }
        $certificateStatus = (new CertificateStatus())->getValue();

        foreach ($certificateStatus as $domain => $days) {
            $this->services[] = [
                'label' => 'SSL',
                'description' => $domain,
                'status' => $days > 14,
                'value' => $days . 'd',
            ];
        }

        $this->services = array_merge($this->services, [
            [
                'label' => 'FTP',
                'status' => (new Ftp('ftp'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'SFTP',
                'status' => (new Ftp('sftp'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Horizon',
                'status' => $horizon > 10,
                'value' => $horizon,
            ],
            [
                'label' => 'Queue',
                'status' => $queue['total'] < config('horizon.queue_max'),
                'value' => $queue['format'],
            ],
            [
                'label' => 'default',
                'status' => $wait['default']['total'] < config('horizon.default_wait_max'),
                'value' => $wait['default']['format'],
            ],
            [
                'label' => 'metric-data',
                'status' => $wait['metric-data']['total'] < config('horizon.metric_data_wait_max'),
                'value' => $wait['metric-data']['format'],
            ],
            [
                'label' => 'realtime',
                'status' => $wait['realtime']['total'] < config('horizon.realtime_wait_max'),
                'value' => $wait['realtime']['format'],
            ],
            [
                'label' => 'AWS',
                'status' => $aws <= 0,
                'value' => $aws,
            ],
            [
                'label' => 'NTP',
                'status' => (new Udp('ntp.vemcount.com', 123))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Vemco.group',
                'status' => (new Up('https://www.vemcount.com'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Vemcount',
                'status' => (new Up('https://vemcount.app'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Xovis',
                'status' => (new Up('https://xovis.vemcount.com:3002'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Brickstream',
                'status' => (new Tcp('brickstream.vemcount.com', 3000))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Irisys',
                'status' => (new Tcp('irisys.vemcount.com'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Stunnel',
                'status' => (new Tcp('java-app1.vemcount.com', 443))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'MQTT',
                'status' => (new Tcp('data.vemcount.com', 1883))->getValue(),
                'value' => 'Offline',
            ],
        ]);

        event(new DevServices($this->services));
    }
}
