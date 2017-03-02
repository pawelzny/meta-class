<?php
/**
 * Composable it's not an real Composition Pattern implementation.
 * It's just an supplement for MetaCompose purposes.
 *
 * @package Pawelzny\MetaClass\Contracts
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass\Contracts;

/**
 * Composable is dedicated for MetaCompose and it's child classes.
 * Provides set of methods which every Compose should implement.
 *
 * Composable expose with() method which supplies
 * extra arguments for component.
 * In fact whole set of args will be passed to every
 * registered component. These components may use them or not.
 *
 * compose() method is meant for perform computation.
 *
 * @package Pawelzny\MetaClass\Contracts
 */
interface Composable
{
    /**
     * Passes required arguments to Composable component.
     * In example by default model object is passed as one of argument.
     * This method can be omitted.
     *
     * @param  array $args
     * @return static
     */
    public function with(array $args = []);

    /**
     * Compose method is meant to execute computations,
     * store result in temporary variable then
     * close all used files and external connections.
     *
     * @return static
     */
    public function compose();
}
