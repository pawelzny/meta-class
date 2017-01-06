<?php

namespace Pawelzny\Monads;

class Maybe extends Monad
{
    protected function maybe()
    {
        return ! is_null($this->value);
    }

    public function bind(\Closure $function, array $args = [])
    {
        if ($this->maybe()) {
            return parent::bind($function, $args);
        }

        return new static(null);
    }
}

class MaybeNot extends Maybe
{
    protected function maybe()
    {
        return ! parent::maybe();
    }
}
