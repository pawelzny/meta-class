<?php

namespace Pawelzny\MetaClass\Model;

use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

abstract class MetaClass implements MetaExpansible
{
    /**
     * @var array Meta methods register
     */
    protected $methods = [];

    /**
     * @var array Meta attributes register
     */
    protected $attributes = [];

    /**
     * Calls registered method. Throws MetaMethodException if method
     * does not exist.
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws MetaMethodException
     */
    public function __call($method, $arguments)
    {
        if (! array_key_exists($method, $this->methods)) {
            throw new MetaMethodException($method);
        }

        return call_user_func_array($this->methods[$method], $arguments);
    }

    /**
     * Puts new meta method and meta attributes in the registry.
     * @param $property
     * @param $value
     * @return void
     */
    public function __set($property, $value)
    {
        if (is_callable($value)) {
            $this->setMethod($property, $value);
        } else {
            $this->setAttribute($property, $value);
        }
    }

    /**
     * Retrieves meta methods and meta attributes from the registry.
     * @param $attribute
     * @return mixed
     * @throws MetaAttributeException
     */
    public function __get($attribute)
    {
        if (! array_key_exists($attribute, $this->attributes)) {
            throw new MetaAttributeException($attribute);
        }

        return $this->attributes[$attribute];
    }

    /**
     * Adds new attribute to the registry.
     * @param string $name
     * @param mixed $value
     * @return MetaExpansible
     */
    abstract protected function setAttribute($name, $value);

    /**
     * Adds new method to the registry.
     * @param $name
     * @param callable $closure
     * @return MetaExpansible
     */
    abstract protected function setMethod($name, callable $closure);

    /**
     * Predicates if Object has own not null property.
     * @param string $name
     * @return bool
     */
    abstract protected function hasProperty($name);
}
