<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaMethodException extends MetaClassException
{
    protected $message = 'Undefined meta method: ';
    protected $code = 350;
}
