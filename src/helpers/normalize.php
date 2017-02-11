<?php

if(! function_exists('to_snake_case')) {
    /**
     * Converts PascalCase to snake_case string
     * @see http://stackoverflow.com/a/35719689
     * @param string $string
     * @return string
     */
    function to_snake_case($string) {
        $regex = ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'];

        return strtolower(preg_replace($regex, '$1_$2', $string));
    }
}
