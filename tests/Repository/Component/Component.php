<?php

namespace Pawelzny\Tests\Repository\Component;

use Pawelzny\MetaClass\Contracts\Composable;

/**
 * Class Component
 * @package Pawelzny\Tests\Repository\Component
 */
class Component implements Composable
{
    protected $properties;
    protected $test_case;

    public function compose()
    {
        $this->test_case = [
            'name' => static::class,
        ];

        if (array_key_exists('some_argument', $this->properties)) {
            $this->test_case['some_argument'] = 'abc';
        }

        if (array_key_exists('env', $this->properties)) {
            $this->test_case['env'] = 'test';
        }

        return $this;
    }

    public function with(array $properties = [])
    {
        $this->properties = $properties;

        return $this;
    }

    public function andReturn()
    {
        return $this->test_case;
    }
}
