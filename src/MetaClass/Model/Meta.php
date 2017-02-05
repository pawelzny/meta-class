<?php

namespace Pawelzny\MetaClass\Model;

use Pawelzny\MetaClass\Contracts\MetaExpansible;

class Meta extends MetaClass implements MetaExpansible
{
    /**
     * Model instance
     * @var object
     */
    protected $model = null;

    /**
     * Meta constructor.
     * @param object $model
     */
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    /**
     * Predicates if MetaExpansible has model instance.
     * @return bool
     */
    public function hasModel()
    {
        return $this->hasProperty('model');
    }

    /**
     * Sets model instance
     * @param $model
     * @return MetaExpansible
     */
    public function setModel($model)
    {
        if (! $this->hasModel()) {
            $this->model = $model;
        }

        return $this;
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
     * Predicates if Object has own not null property.
     * @param string $name
     * @return bool
     */
    protected function hasProperty($name)
    {
        return property_exists($this, $name) && isset($this->{$name});
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
