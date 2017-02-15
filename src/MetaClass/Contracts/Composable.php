<?php

namespace Pawelzny\MetaClass\Contracts;

/**
 * Interface Composable
 *
 * @package Pawelzny\MetaClass\Contracts
 */
interface Composable
{
    /**
     * Compose meta features from declared components
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function compose();

    /**
     * @param array $properties
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function with(array $properties = []);

    /**
     * @return mixed
     */
    public function andReturn();
}
