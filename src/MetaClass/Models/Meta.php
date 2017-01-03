<?php

namespace Pawelzny\MetaClass\Models;

class Meta extends MetaClass
{
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
}
