<?php

namespace Pawelzny\Tests\Repository\Component;

use Pawelzny\MetaClass\Contracts\Composable;

/**
 * Class Component
 * @package Pawelzny\Tests\Repository\Component
 */
class Component extends \Pawelzny\MetaClass\Component implements Composable
{
    public function compose()
    {
        $this->result = [
            'name' => static::class,
        ];

        if (array_key_exists('some_argument', $this->args)) {
            $this->result['some_argument'] = 'abc';
        }

        if (array_key_exists('env', $this->args)) {
            $this->result['env'] = 'test';
        }

        return $this;
    }
}
