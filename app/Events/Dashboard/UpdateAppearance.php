<?php

namespace App\Events\Dashboard;

class UpdateAppearance
{
    /** @var string */
    public $mode;

    public function __construct(string $mode)
    {
        $this->mode = $mode;
    }
}
