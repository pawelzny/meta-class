<?php

namespace Pawelzny\Monads;

abstract class Monad
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function unit($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        return new static($value);
    }

    public function then(\Closure $function, array $args = [])
    {
        return $this->unit($this->exec($function, $this->value, $args));
    }

    public function extract()
    {
        if ($this->value instanceof static) {
            return $this->value->extract();
        }

        return $this->value;
    }

    protected function exec(\Closure $function, $value, array $args = [])
    {
        if ($value instanceof static) {
            return $value->then($function, $args);
        }
        array_unshift($args, $value);

        return call_user_func_array($function, $args);
    }
}
