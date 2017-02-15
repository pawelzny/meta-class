<?php

namespace Pawelzny\MetaClass\Exceptions;

class MetaClassException extends \Exception
{
    protected $message = 'Meta class general exception occurs. Too broad exception clause.';
    protected $code = 0;

    /**
     * MetaAttributeException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = null, \Exception $previous = null)
    {
        $this->message .= $message;

        if (is_int($code)) {
            $this->code = $code;
        }
        
        parent::__construct($this->message, $this->code, $previous);
    }
}
