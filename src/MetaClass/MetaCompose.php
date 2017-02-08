<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Contracts\MetaExpansible;

class MetaCompose extends MetaModel implements MetaExpansible, Composable
{
    /**
     * Associative array of Composable extensions
     * which are booted on MetaCompose initialization.
     * @var array
     */
    protected $components = [];

    /**
     * Compose meta features from declared $components
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function compose()
    {
        foreach ($this->components as $component => $class) {
            if ($this->isComposable($class)) {
                $this->setAttribute($component, $class->with(['model' => $this->model])->compose()->andReturn());
            }
        }

        return $this;
    }

    /**
     * @param array $properties
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function with(array $properties = [])
    {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function andReturn()
    {
        return $this;
    }

    /**
     * Predicate if MetaClass is schema discoverable
     * @param $class
     * @return bool
     */
    private function isComposable($class)
    {
        return $class !== null && in_array('Composable', class_implements($class));
    }
}
