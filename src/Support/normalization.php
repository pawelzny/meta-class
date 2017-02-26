<?php
/**
 * Normalization helpers.
 * These functions are not in strict relationship with rest of package.
 * I decide to put them in separation because in future all helpers
 * will be exported to external package and used as dependency.
 *
 * @package Pawelzny\Support\Normalization
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\Support\Normalization;

/**
 * Converts PascalCase and camelCase to snake_case string
 *
 * @see    http://stackoverflow.com/a/35719689
 * @example
 * <code>
 * use \Pawelzny\Support\toSnakeCase;
 *
 * toSnakeCase('PascalCaseIsCool'); // 'pascal_case_is_cool'
 * toSnakeCase('camelCaseIsFun');   // 'camel_case_is_fun'
 * </code>
 *
 * @param  string $string
 *
 * @return string
 */
function toSnakeCase($string)
{
    $regex = ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'];

    return strtolower(preg_replace($regex, '$1_$2', $string));
}
