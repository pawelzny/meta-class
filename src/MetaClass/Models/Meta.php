<?php

namespace Pawelzny\MetaClass\Models;

use Pawelzny\Discovery\Traits\SchemaDiscovery;

class Meta extends MetaClass
{
    /**
     * @var object Class instance
     */
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
        if ($this->hasTrait(SchemaDiscovery::class)) {
            try {
                $this->setAttribute('fields', $this->class->discover()->getModelFields());
            } catch (\Exception $exception) {
                /** discover() method has been wrongly overridden */
                throw new \Exception("Method discover() do not call it's parent method");
            }
        }
    }

    /**
     * Predicates if Object has meta method in the registry.
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name)
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * Predicates if Object has meta attribute in the registry.
     * @param {string} $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Predicates if Object uses given trait
     * @param string $trait with namespace
     * @return bool
     */
    public function hasTrait($trait)
    {
        return in_array($trait, class_uses($this->class));
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param \Closure $closure
     * @return $this
     */
    protected function setMethod($name, \Closure $closure)
    {
        $this->methods[$name] = $closure;

        return $this;
    }
}
