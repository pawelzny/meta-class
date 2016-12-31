<?php

namespace Pawelzny\MetaClass\Exceptions;

class ForbiddenException extends \Exception
{
    public function __construct($property = "", $code = 0, \Exception $previous = null)
    {
        $message = "Forbidden direct assignment to property: $property";
        parent::__construct($message, $code, $previous);
    }
}
