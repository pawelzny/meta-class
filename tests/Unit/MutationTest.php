<?php

use Pawelzny\Support\Mutation;
use Pawelzny\Tests\Repository\Component\Component;
use PHPUnit\Framework\TestCase;

class MutationTest extends TestCase
{
    public function testGetClassName()
    {
        $component = new Component;

        $this->assertEquals('component', Mutation\getClassName($component));
        $this->assertEquals('custom_component', Mutation\getClassName($component, 'custom_component'));
        $this->assertEquals('component', Mutation\getClassName($component, '5'));
        $this->assertEquals('component', Mutation\getClassName($component, 32));
        $this->assertEquals('component', Mutation\getClassName($component, 12.1233));
        $this->assertEquals('component', Mutation\getClassName($component, true));
        $this->assertEquals('component', Mutation\getClassName($component, new stdClass));
    }
}
