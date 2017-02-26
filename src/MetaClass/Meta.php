<?php
/**
 * MetaClass base implementation.
 *
 * @package Pawelzny\MetaClass
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

/**
 * Meta is an basic implementation.
 * It's not an abstract but should be treated like one.
 *
 * @package Pawelzny\MetaClass
 */
class Meta implements MetaExpansible
{
    /**
     * Meta methods registry
     *
     * @var array $methods
     */
    protected $methods = [];

    /**
     * Meta attributes registry
     *
     * @var array $attributes
     */
    protected $attributes = [];

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
    public function __call($method, $arguments)
    {
        if (! array_key_exists($method, $this->methods)) {
            throw new MetaMethodException($method);
        }

        return call_user_func_array($this->methods[$method], $arguments);
    }

    /**
     * Detects if set value is callable and if it is, puts new method
     * in methods registry. Otherwise puts value in attributes registry.
     *
     * @param  string $property
     * @param  mixed  $value
     *
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
     * Is used when isset() or empty() function are called on
     * meta object.
     *
     * @param  $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return ! empty($this->attributes) && ! empty($this->methods);
    }

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
     * @param  string $name
     *
     * @api
     * @return boolean
     */
    public function hasMethod($name)
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * Predicates if Meta class has meta attribute in the registry.
     *
     * @param  string $name
     *
     * @api
     * @return boolean
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Adds new method to the registry.
     *
     * @param  string   $name
     * @param  callable $method
     *
     * @api
     * @return static
     */
    protected function setMethod($name, callable $method)
    {
        $this->methods[$name] = $method;

        return $this;
    }

    /**
     * Adds new attribute to the registry.
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @api
     * @return static
     */
    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }
}
