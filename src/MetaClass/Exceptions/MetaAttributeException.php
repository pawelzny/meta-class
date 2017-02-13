<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaAttributeException extends MetaClassException
{
    protected $message = "Undefined meta attribute: ";

    /**
     * MetaAttributeException constructor.
     * @param string $attribute
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($attribute = "", $code = 0, \Exception $previous = null)
    {
        $this->message = $this->message . $attribute;
    }
}
