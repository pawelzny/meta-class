<?php
/**
 * Whenever there is need to create whole new Meta subclass,
 * it should implement MetaExpansible interface.
 * Before new implementation, give a closer look at
 * base implementation in Meta.php
 *
 * @package Pawelzny\MetaClass\Contracts
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass\Contracts;

/**
 * Interface MetaExpansible
 * Every meta class implements or inherit implementation
 * of MetaExpansible interface.
 *
 * @package Pawelzny\MetaClass\Contracts
 */
interface MetaExpansible
{
    /**
     * Meta stores it's methods in registry to allow dynamic creation
     * of new methods.
     *
     * __call search for method in registry and invoke it if exist.
     * Otherwise throws MetaMethodException.
     *
     * @param  string $method
     * @param  array  $arguments
     *
     * @return mixed
     * @throws \Pawelzny\MetaClass\Exceptions\MetaMethodException
     */
    public function __call($method, $arguments);

    /**
     * Detects if set value is callable and if it is, puts new method
     * in methods registry. Otherwise puts value in attributes registry.
     *
     * @param  string $property
     * @param  mixed  $value
     *
     * @return void
     */
    public function __set($property, $value);

    /**
     * Is used when isset() or empty() function are called on
     * meta object.
     *
     * @param  $name
     *
     * @return boolean
     */
    public function __isset($name);

    /**
     * Meta stores it's attributes in registry to allow dynamic
     * setting and getting them.
     *
     * __get search for attribute in registry and returns it's value.
     * Otherwise throws an MetaAttributeException.
     *
     * @param  string $attribute
     *
     * @return mixed
     * @throws \Pawelzny\MetaClass\Exceptions\MetaAttributeException
     */
    public function __get($attribute);
}
