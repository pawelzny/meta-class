<?php

namespace Pawelzny\MetaClass\Model;

use Pawelzny\MetaClass\Contracts\MetaExpansible;

class Meta extends MetaClass implements MetaExpansible
{
    /**
     * Configurator will look for this property inside Model instance.
     * @var string
     */
    protected $meta_config_property = 'meta_config';

    /**
     * Model instance
     * @var object
     */
    private $model;

    /**
     * MetaConfig instance
     * @var object
     */
    private $config;

    /**
     * Meta constructor.
     * @param object $model
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->configurator();
    }

    /**
     * Predicates if Object has meta method in the registry.
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name): bool
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * Predicates if Object has meta attribute in the registry.
     * @param string $name
     * @return bool
     */
    public function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Adds new attribute to the registry.
     * @param string $name
     * @param mixed $value
     * @return MetaExpansible
     */
    protected function setAttribute(string $name, $value): MetaExpansible
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Adds new method to the registry.
     * @param $name
     * @param callable $closure
     * @return MetaExpansible
     */
    protected function setMethod(string $name, callable $closure): MetaExpansible
    {
        $this->methods[$name] = $closure;

        return $this;
    }

    /**
     * MetaClass config executor
     */
    protected function configurator()
    {
        if (! $this->config && property_exists($this->model, $this->meta_config_property)) {
            $this->config = new $this->model->{$this->meta_config_property}();
            $this->config->execute();
        }
    }
}
