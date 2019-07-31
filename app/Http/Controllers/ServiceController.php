<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiIntegration\Web\Up;
use App\ApiIntegration\Web\Tcp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Collective\Remote\RemoteFacade as SSH;
use App\SystemServiceInteraction\Instruction;
use App\SystemServiceInteraction\SystemCommand;

class ServiceController
{
    public $services = [];

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->services = [
            'Xovis' => [
                'name' => 'Xovis',
                'commands' => [
                    new SystemCommand('sudo systemctl restart ibex.service'),
                    new SystemCommand('sudo systemctl restart ibex-auth.service'),
                    new SystemCommand('sudo systemctl restart ibex-instance-manager.service'),
                ],
                'status' => (new Up('https://xovis.vemcount.com:3002'))->getValue(),
            ],
            'Brickstream' => [
                'name' => 'Brickstream',
                'commands' => [
                    new SystemCommand('sudo systemctl restart vemstream.service'),
                    new SystemCommand('sudo systemctl restart bs_proxy.service'),
                    new SystemCommand('sudo systemctl restart bs_smartadapter.service'),
                    new SystemCommand('sudo systemctl restart bs_taskmgr.service'),
                    new SystemCommand('sudo systemctl restart tomcat.service'),
                ],
                'status' => (new Tcp('brickstream.vemcount.com', 3000))->getValue(),
            ],
            'Irisys' => [
                'name' => 'Irisys',
                'commands' => [
                    new SystemCommand('sudo systemctl restart irisys.service'),
                ],
                'status' => (new Tcp('irisys.vemcount.com'))->getValue(),
            ],
            'TDI' => [
                'name' => 'TDI',
                'commands' => [
                    new SystemCommand('sudo docker restart 5db02865401f'),
                ],
                'status' => (new Tcp('java-app1.vemcount.com', 8081))->getValue(),
            ],
        ];
    }

    public function restart(Request $request): JsonResponse
    {
        $commandsToExecute = [];
        $outputFromHost = [];

        if ($request->has('service')) {

            $services = explode(',', $request->get('service'));

            foreach ($services as $service) {
                /**
                 * @var Instruction $instruction
                 */
                foreach ($this->services[$service]['commands'] as $instruction) {
                    $commandsToExecute[] = $instruction->execute();
                }
            }

            if (app()->environment('production')) {
                SSH::group('java')
                    ->run($commandsToExecute, function ($line) use ($outputFromHost) {
                        $outputFromHost[] = $line;
                    });
            } else {
                Log::info('Would run the follow commands:');

                foreach ($commandsToExecute as $command) {
                    Log::info($command);
                }
            }
        }

        return response()->json('Success');
    }
}
