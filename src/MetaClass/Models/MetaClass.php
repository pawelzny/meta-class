<?php

namespace Pawelzny\MetaClass\Models;

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

abstract class MetaClass
{
    /**
     * @var object Class instance
     */
    protected $class;
    /**
     * @var array Meta methods register
     */
    protected $methods = [];
    /**
     * @var array Meta attributes register
     */
    protected $attributes = [];

    /**
     * MetaClass constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

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
        if ($value instanceof \Closure) {
            $this->methods[$property] = $value;
        } else {
            $this->attributes[$property] = $value;
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
}
