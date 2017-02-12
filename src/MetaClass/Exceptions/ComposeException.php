<?php

namespace Pawelzny\MetaClass\Exceptions;

class ComposeException extends MetaClassException
{
    protected $message = "Component does not implement \\Pawelzny\\MetaClass\\Contracts\\Composable Interface: ";

    /**
     * NotComposableComponentException constructor.
     * @param object $component
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($component, $code = 0, \Exception $previous = null)
    {
        $this->message = $this->message . get_class($component);
    }
}
