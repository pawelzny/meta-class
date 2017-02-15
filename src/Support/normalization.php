<?php

namespace Pawelzny\Support;

/**
 * Converts PascalCase to snake_case string
 *
 * @see http://stackoverflow.com/a/35719689
 * @param string $string
 * @return string
 */
function toSnakeCase($string)
{
    $regex = ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'];

    return strtolower(preg_replace($regex, '$1_$2', $string));
}

/**
 * Sanitize Component name.
 * If name is index of array or null then return snake_case class name.
 *
 * @param mixed $component
 * @param string|int $name
 * @return string
 */
function getClassName($component, $name = null)
{
    if (is_string($name) && ! is_numeric($name)) {
        return $name;
    }

    $component = new \ReflectionClass($component);
    return toSnakeCase($component->getShortName());
}
