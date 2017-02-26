<?php
/**
 * Mutation helpers.
 * These functions are not in strict relationship with rest of package.
 * I decide to put them in separation because in future all helpers
 * will be exported to external package and used as dependency.
 *
 * @package Pawelzny\Support\Mutation
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\Support\Mutation;

/**
 * Returns object's class name without namespace in snake_case
 * if second parameter is provided will be used instead.
 *
 * $name can be integer if you process mixed arrays, where some
 * keys are numeric and some strings.
 * When $name is a valid string then will be used as alias name for given object.
 *
 * @example
 * <code>
 * $objects = [
 *  $user,                      // instance of User
 *  $role,                      // instance of Role
 *  'company' => $workplace     // instance of Workplace
 * ];
 * $registry = [];
 * foreach ($objects as $key => $obj) {
 *   $registry[] = getClassName($obj, $key);
 * }
 *
 * assertEquals(['user', 'role', 'company'], $registry);
 * </code>
 *
 * @param  mixed          $obj
 * @param  string|integer $name
 *
 * @return string
 */
function getClassName($obj, $name = null)
{
    if (is_string($name) && ! is_numeric($name)) {
        return $name;
    }
    $obj = new \ReflectionClass($obj);

    return \Pawelzny\Support\Normalization\toSnakeCase($obj->getShortName());
}
