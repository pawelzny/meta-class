<?php namespace Pawelzny\Discovery\Models;

abstract class Discovery
{
    protected $class = null;

    public function __construct($class)
    {
        $this->class = $class;
    }
}
