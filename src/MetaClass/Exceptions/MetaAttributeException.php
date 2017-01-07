<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaAttributeException extends \Exception
{
    /**
     * MetaAttributeException constructor.
     * @param string $attribute
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($attribute = "", $code = 0, \Exception $previous = null)
    {
        $message = "Undefined meta attribute: $attribute";
        parent::__construct($message, $code, $previous);
    }
}
