<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

class Meta implements MetaExpansible
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
     * @param string $method
     * @param array $arguments
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
     * @param string $property
     * @param mixed $value
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
     * @param string $attribute
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
     * Predicates if MetaExpansible has meta method in the registry.
     * @param string $name
     * @return bool
     */
    public function hasMethod($name)
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * Predicates if MetaExpansible has meta attribute in the registry.
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Adds new method to the registry.
     * @param $name
     * @param callable $closure
     * @return MetaExpansible
     */
    protected function setMethod($name, callable $closure)
    {
        $this->methods[$name] = $closure;

        return $this;
    }

    /**
     * Adds new attribute to the registry.
     * @param string $name
     * @param mixed $value
     * @return MetaExpansible
     */
    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }
}
