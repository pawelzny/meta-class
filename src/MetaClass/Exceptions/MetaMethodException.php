<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaMethodException extends \Exception
{
    public function __construct($method = "", $code = 0, \Exception $previous = null)
    {
        $message = "Undefined meta method: $method";
        parent::__construct($message, $code, $previous);
    }
}
