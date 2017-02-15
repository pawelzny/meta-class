<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaAttributeException extends MetaClassException
{
    protected $message = 'Undefined meta attribute: ';
    protected $code = 300;
}
