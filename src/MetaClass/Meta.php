<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

/**
 * Class Meta
 *
 * @package Pawelzny\MetaClass
 */
class Meta implements MetaExpansible
{
    /**
     * @var array $methods Meta methods registry
     */
    protected $methods = [];

    /**
     * @var array $attributes Meta attributes registry
     */
    protected $attributes = [];

    /**
     * Calls registered method. Throws MetaMethodException if method
     * does not exist.
     *
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
     *
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
     * Is triggered by calling isset() or empty() on object.
     * @param $name
     * @return boolean
     */
    public function __isset($name)
    {
        return ! empty($this->attributes) && ! empty($this->methods);
    }

    /**
     * Retrieves meta methods and meta attributes from the registry.
     *
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
     * Predicates if Meta class has meta method in the registry.
     *
     * @api
     * @param string $name
     * @return boolean
     */
    public function hasMethod($name)
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * Predicates if Meta class has meta attribute in the registry.
     *
     * @api
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Adds new method to the registry.
     *
     * @api
     * @param string $name
     * @param callable $closure
     * @return static
     */
    protected function setMethod($name, callable $closure)
    {
        $this->methods[$name] = $closure;

        return $this;
    }

    /**
     * Adds new attribute to the registry.
     *
     * @api
     * @param string $name
     * @param mixed $value
     * @return static
     */
    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }
}
