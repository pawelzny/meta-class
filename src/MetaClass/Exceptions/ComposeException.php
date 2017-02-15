<?php

namespace Pawelzny\MetaClass\Exceptions;

class ComposeException extends MetaClassException
{
    protected $message = 'Component does not implement \\Pawelzny\\MetaClass\\Contracts\\Composable Interface: ';
    protected $code = 200;
}
