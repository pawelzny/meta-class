<?php

namespace Pawelzny\MetaClass\Contracts;

interface MetaExpansible
{
    /**
     * Calls registered method. Throws MetaMethodException if method
     * does not exist.
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Pawelzny\MetaClass\Exceptions\MetaMethodException
     */
    public function __call($method, $arguments);

    /**
     * Puts new meta method and meta attributes in the registry.
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value);

    /**
     * Retrieves meta methods and meta attributes from the registry.
     * @param string $attribute
     * @return mixed
     * @throws \Pawelzny\MetaClass\Exceptions\MetaAttributeException
     */
    public function __get($attribute);
}
