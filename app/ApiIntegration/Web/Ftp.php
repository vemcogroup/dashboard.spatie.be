<?php

namespace App\ApiIntegration\Web;

use Exception;
use App\ApiIntegration\ApiIntegration;
use Illuminate\Support\Facades\Storage;

class Ftp extends ApiIntegration
{
    protected $disk;
    protected $timestamp;

    public function __construct($disk = 'ftp')
    {
        $this->disk = $disk;
        $this->timestamp = time();
    }

    public function testWriteDelete()
    {
        Storage::disk($this->disk)->put('service-test-'.$this->timestamp.'txt', 'OK');
        Storage::disk($this->disk)->delete('service-test-'.$this->timestamp.'.txt');
    }

    public function getValue()
    {
        try {
            $this->testWriteDelete();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
