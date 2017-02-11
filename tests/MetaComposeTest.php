<?php

require_once "factory/Model.php";

use Pawelzny\MetaClass\MetaCompose;
use PHPUnit\Framework\TestCase;

class MetaComposeTest extends TestCase
{
    public function testSetComponents()
    {
        $meta = new MetaCompose;

        $meta->setComponents(Component::class)
             ->setComponents([
                 'component_copy' => Component::class,
                 'component_copy_copy' => Component::class
             ]);

        $this->assertCount(3, $meta->getComponents());
        $this->assertArrayHasKey('component', $meta->getComponents());
        $this->assertArrayHasKey('component_copy', $meta->getComponents());
        $this->assertArrayHasKey('component_copy_copy', $meta->getComponents());
        $this->assertEquals(Component::class, $meta->getComponents()['component']);
    }

    public function testWith()
    {
        $meta = new MetaCompose;

        $meta->with(['test' => true, 'flag' => null])
             ->with(['flag' => false]); // should override flag argument

        // expected 3 because "model" argument is set for every MetaCompose instance.
        $this->assertCount(3, $meta->getArgs());
        $this->assertArrayHasKey('model', $meta->getArgs());
        $this->assertArrayHasKey('test', $meta->getArgs());
        $this->assertArrayHasKey('flag', $meta->getArgs());
        $this->assertFalse($meta->getArgs('flag'));
    }

    public function testCompose()
    {
        $model = new Model;
        $meta = new MetaCompose($model);

        $meta->setComponents(['super_component' => Component::class])
             ->with([
                 'env' => 'test',
                 'some_argument' => 'abc',
             ])
             ->compose();

        $this->assertEquals('abc', $meta->super_component['some_argument']);
        $this->assertEquals('test', $meta->super_component['env']);
    }
}
