<?php namespace Pawelzny\Discovery\Models;

use Pawelzny\Discovery\Services\Environment;

abstract class Discovery
{
    protected $class = null;

    public function __construct($class)
    {
        $this->class = $class;
    }
}
