<?php

namespace App\ApiIntegration\Web;

use Exception;
use App\ApiIntegration\ApiIntegration;
use Symfony\Component\Process\Process;

class Udp extends ApiIntegration
{
    protected $domain;
    protected $port;

    public function __construct($domain, $port = '123')
    {
        $this->domain = $domain;
        $this->port = $port;
    }

    protected function getShellCommand(): string
    {
        return 'nc -uzv ' . $this->domain . ' ' . $this->port . '; echo $?';
    }

    public function getValue()
    {
        try {
            $process = Process::fromShellCommandline($this->getShellCommand());
            $process->run();

            if (!$process->isSuccessful()) {
                return false;
            }

            return strstr($process->getOutput(), "0\n");
        } catch (Exception $e) {
            return false;
        }
    }
}
