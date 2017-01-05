<?php namespace Pawelzny\Discovery\Models;

use Pawelzny\Discovery\Services\Environment;

abstract class Discovery
{
    protected $class = null;
    protected $environment = Environment::class;

    public function __construct($class)
    {
        $this->class = $class;
        $this->environment = new $this->environment();
    }
}
