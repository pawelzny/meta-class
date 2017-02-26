<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;

abstract class Component implements Composable
{
    /**
     * Arguments for compose
     *
     * @var array $args
     */
    protected $args = [];

    /**
     * Compose result
     *
     * @var mixed $result
     */
    protected $result;

    /**
     * Passes required arguments to Composable component.
     * In example by default model object is passed as one of argument.
     * This method can be omitted.
     *
     * @param  array $args
     *
     * @api
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function with(array $args = [])
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Compose method is meant to execute computations,
     * store result in temporary variable then
     * close all used files and external connections.
     *
     * @api
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    abstract public function compose();

    /**
     * Ends method chain and returns computed value.
     *
     * @api
     * @return mixed
     */
    public function andReturn()
    {
        return $this->result;
    }
}
