<?php

namespace App\Events\GitLab;

class LabelsFetched
{
    /** @var array */
    public $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }
}
