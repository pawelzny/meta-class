<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaAttributeException extends \Exception
{
    public function __construct($attribute = "", $code = 0, \Exception $previous = null)
    {
        $message = "Undefined meta attribute: $attribute";
        parent::__construct($message, $code, $previous);
    }
}
