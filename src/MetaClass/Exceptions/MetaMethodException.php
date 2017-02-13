<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaMethodException extends MetaClassException
{
    protected $message = "Undefined meta method: ";

    /**
     * MetaMethodException constructor.
     * @param string $method
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($method = "", $code = 0, \Exception $previous = null)
    {
        $this->message = $this->message . $method;
    }
}
