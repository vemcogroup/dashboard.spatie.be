<?php

namespace App\Http\Controllers;

use App\SystemServiceInteraction\Instruction;
use App\SystemServiceInteraction\SystemCommand;
use Collective\Remote\RemoteFacade as SSH;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                ]
            ],
            'Brickstream' => [
                'name' => 'Brickstream',
                'commands' => [
                    new SystemCommand('sudo systemctl restart vemstream.service'),
                    new SystemCommand('sudo systemctl restart bs_proxy.service'),
                    new SystemCommand('sudo systemctl restart bs_smartadapter.service'),
                    new SystemCommand('sudo systemctl restart bs_taskmgr.service'),
                    new SystemCommand('sudo systemctl restart tomcat.service'),
                ]
            ],
            'Irisys' => [
                'name' => 'Irisys',
                'commands' => [
                    new SystemCommand('sudo systemctl restart irisys.service'),
                ]
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
