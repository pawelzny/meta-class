<?php

namespace Pawelzny\MetaClass\Exceptions;

class ComposableException extends \Exception
{
    /**
     * NotComposableComponentException constructor.
     * @param $component
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($component, $code = 0, \Exception $previous = null)
    {
        $message = "Component does not implement \\Pawelzny\\MetaClass\\Contracts\\Composable Interface: " . get_class($component);
        parent::__construct($message, $code, $previous);
    }
}
