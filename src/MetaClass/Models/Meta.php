<?php

namespace Pawelzny\MetaClass\Models;

use Pawelzny\Discovery\Traits\SchemaDiscovery;
use Pawelzny\Monads\Maybe;

class Meta extends MetaClass
{
    /**
     * @var object Class instance
     */
    protected $model;

    /**
     * Meta constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;

        if ($this->hasTrait(SchemaDiscovery::class)) {
            $getModelFields = function ($discover) {
                return $discover->getModelFields();
            };

            $maybe = new Maybe($this->model->discover());
            $fields = $maybe->then($maybe($getModelFields))->extract();

            $this->setAttribute('fields', $fields);
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
        return in_array($trait, class_uses($this->model));
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
     * @param $name
     * @param callable $closure
     * @return $this
     */
    protected function setMethod($name, callable $closure)
    {
        $this->methods[$name] = $closure;

        return $this;
    }
}
