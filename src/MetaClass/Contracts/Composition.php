<?php
/**
 * Component like Composable is not strict implementation of Composition Pattern.
 *
 * @package Pawelzny\MetaClass\Contracts
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass\Contracts;

/**
 * Composition interface is dedicated for Components.
 *
 * Composition exposes methods inherited from Composable,
 * and one more andReturn() used for returning computed value.
 *
 * @package Pawelzny\MetaClass\Contracts
 *
 * @method compose()
 * @method with(array $args = [])
 */
interface Composition extends Composable
{
    /**
     * Ends method chain and returns computed value.
     *
     * @return mixed
     */
    public function andReturn();
}
