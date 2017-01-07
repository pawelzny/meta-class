<?php

namespace Pawelzny\MetaClass\Models;

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

abstract class MetaClass
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
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    abstract protected function setAttribute($name, $value);

    /**
     * @param $name
     * @param callable $closure
     * @return mixed
     */
    abstract protected function setMethod($name, callable $closure);
}
