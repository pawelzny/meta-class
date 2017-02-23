<?php

namespace Pawelzny\Support;

/**
 * Predicates if object implements given interface
 *
 * @param  $object
 * @param  string $interface fully qualified interface name with namespace
 * @return bool
 */
function hasInterface($object, $interface)
{
    return $object !== null && in_array($interface, class_implements($object), $strict = false);
}
