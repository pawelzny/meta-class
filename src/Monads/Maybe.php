<?php

namespace Pawelzny\Monads;

use Pawelzny\Monads\Contracts\MonadInterface;

class Maybe extends Monad implements MonadInterface
{
    /**
     * @param callable $function
     * @param array $args
     * @return MonadInterface
     */
    public function then(callable $function, array $args = [])
    {
        if (! is_null($this->value)) {
            return parent::then($function, $args);
        }

        return new static(null);
    }
}
