<?php
/**
 * Predication helpers.
 * These functions are not in strict relationship with rest of package.
 * I decide to put them in separation because in future all helpers
 * will be exported to external package and used as dependency.
 *
 * @package Pawelzny\Support\Predication
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\Support\Predication;

/**
 * Predicates if object implements given interface
 *
 * @example
 * <code>
 * class User implements Auth
 * {
 * }
 *
 * $user = new User;
 *
 * assertTrue(hasInterface($user, 'Auth');
 * assertFalse(hasInterface($user, 'Role');
 * </code>
 *
 * @param  $object
 * @param  string $interface fully qualified interface name with namespace
 *
 * @return bool
 */
function hasInterface($object, $interface)
{
    return $object !== null && in_array($interface, class_implements($object), $strict = false);
}
