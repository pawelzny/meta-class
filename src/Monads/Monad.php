<?php

namespace Pawelzny\Monads;

use Pawelzny\Monads\Contracts\MonadInterface;

abstract class Monad implements MonadInterface
{
    /**
     * @var mixed value
     */
    protected $value;

    /**
     * Monad constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param callable $function
     * @param array $args
     * @return MonadInterface
     */
    public function then(callable $function, array $args = [])
    {
        return $this->monad($this->exec($function, $this->value, $args));
    }

    /**
     * @return mixed value
     */
    public function extract()
    {
        if ($this->value instanceof static) {
            return $this->value->extract();
        }

        return $this->value;
    }

    /**
     * @param $value
     * @return static
     */
    protected function monad($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        return new static($value);
    }

    /**
     * @param callable $function
     * @param $value
     * @param array $args
     * @return mixed|Monad
     */
    protected function exec(callable $function, $value, array $args = [])
    {
        if ($value instanceof static) {
            return $value->then($function, $args);
        }
        array_unshift($args, $value);

        return call_user_func_array($function, $args);
    }

    /**
     * @param $value
     * @return \Closure
     */
    public function __invoke($value)
    {
        return function () use ($value) {
            try {
                if (is_callable($value)) {
                    $args = func_get_args();

                    return call_user_func_array($value, $args);
                }

                return $value;
            } catch (\Exception $exception) {
            }

            return new static(null);
        };
    }
}
