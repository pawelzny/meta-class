<?php

namespace Pawelzny\MetaClass\Contracts;

interface MetaExpansible
{
    /**
     * Predicates if Object has meta method in the registry.
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name): bool;

    /**
     * Predicates if Object has meta attribute in the registry.
     * @param string $name
     * @return bool
     */
    public function hasAttribute(string $name): bool;
}
