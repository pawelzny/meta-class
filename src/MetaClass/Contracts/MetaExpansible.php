<?php

namespace Pawelzny\MetaClass\Contracts;

interface MetaExpansible
{
    /**
     * Predicates if MetaExpansible has meta method in the registry.
     * @param string $name
     * @return bool
     */
    public function hasMethod($name);

    /**
     * Predicates if MetaExpansible has meta attribute in the registry.
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name);

    /**
     * Predicates if MetaExpansible has model instance.
     * @return bool
     */
    public function hasModel();

    /**
     * Sets model instance
     * @param $model
     * @return MetaExpansible
     */
    public function setModel($model);
}
