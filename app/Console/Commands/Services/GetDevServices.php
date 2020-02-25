<?php

namespace App\Console\Commands\Services;

use App\ApiIntegration\Web\Up;
use App\ApiIntegration\Web\Udp;
use App\ApiIntegration\Web\Tcp;
use App\ApiIntegration\Web\Ftp;
use Illuminate\Console\Command;
use App\ApiIntegration\AWS\Alarms;
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
            $queue = 999999;
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
                'status' => $queue > 100000,
                'value' => $queue,
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
                'label' => 'Website',
                'status' => (new Up('https://www.vemcount.com'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Vemcount',
                'status' => (new Up('https://vemcount.app'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'VC São Paulo',
                'status' => (new Up('https://18.231.94.30'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'VC Singapore',
                'status' => (new Up('https://52.77.137.57'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'App1',
                'status' => (new Up('https://central-app1.vemcount.com'))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'Licenses',
                'status' => (new Up('https://license.vemcount.com'))->getValue(),
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
                'label' => 'TDI',
                'status' => (new Tcp('java-app1.vemcount.com', 8081))->getValue(),
                'value' => 'Offline',
            ],
            [
                'label' => 'TDI Sensor',
                'status' => (new Tcp('java-app1.vemcount.com', 4003))->getValue(),
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
