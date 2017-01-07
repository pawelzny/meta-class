<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaMethodException extends \Exception
{
    /**
     * MetaMethodException constructor.
     * @param string $method
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($method = "", $code = 0, \Exception $previous = null)
    {
        $message = "Undefined meta method: $method";
        parent::__construct($message, $code, $previous);
    }
}
