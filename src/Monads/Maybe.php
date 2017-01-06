<?php

namespace Pawelzny\Monads;

class Maybe extends Monad
{
    protected function maybe()
    {
        return ! is_null($this->value);
    }

    public function then(\Closure $function, array $args = [])
    {
        if ($this->maybe()) {
            return parent::then($function, $args);
        }

        return new static(null);
    }
}
