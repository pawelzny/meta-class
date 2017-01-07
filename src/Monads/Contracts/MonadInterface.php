<?php

namespace Pawelzny\Monads\Contracts;

interface MonadInterface
{
    /**
     * @param callable $function
     * @param array $args
     * @return MonadInterface
     */
    public function then(callable $function, array $args = []);

    /**
     * @return mixed value
     */
    public function extract();
}
