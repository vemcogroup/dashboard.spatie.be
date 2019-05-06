<?php

namespace App\Console\Commands\Services;

use App\ApiIntegration\Web\Up;
use App\ApiIntegration\Web\Ftp;
use Illuminate\Console\Command;
use App\Events\Services\DevServices;
use App\ApiIntegration\Horizon\Processes;

class GetDevServices extends Command
{
    protected $signature = 'dashboard:get-dev-services';

    protected $description = 'Get dev services status';
    protected $services = [];

    public function handle(): void
    {
        $this->services = [
            [
                'label' => 'FTP',
                'status' => (new Ftp('ftp'))->getValue(),
            ], [
                'label' => 'SFTP',
                'status' => (new Ftp('sftp'))->getValue(),
            ], [
                'label' => 'Horizon',
                'status' => (new Processes())->getValue() > 10,
            ], [
                'label' => 'Website',
                'status' => (new Up('https://www.vemcount.com'))->getValue(),
            ], [
                'label' => 'App1',
                'status' => (new Up('https://central-app1.vemcount.com'))->getValue(),
            ], [
                'label' => 'App2',
                'status' => (new Up('https://central-app2.vemcount.com'))->getValue(),
            ], [
                'label' => 'Licenses',
                'status' => (new Up('https://license.vemcount.com'))->getValue(),
            ], [
                'label' => 'Cachet',
                'status' => (new Up('https://status.vemcogroup.com', false))->getValue(),
            ]
        ];

        event(new DevServices($this->services));
    }
}
