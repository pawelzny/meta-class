<?php

require_once "factory/Model.php";

use Pawelzny\MetaClass\MetaCompose;
use PHPUnit\Framework\TestCase;

class MetaClassTraitTest extends TestCase
{
    public function testAccessMeta()
    {
        $class = new ModelWithTrait;

        $this->assertSame(MetaCompose::class, get_class($class->meta()));
        $this->assertFalse($class->meta()->hasAttribute('extra_attr')); // property should not exist in any scope

        $class->meta()->extra_attr = "This is meta extra attribute"; // create new meta attribute

        $this->assertFalse(property_exists($class, 'extra_attr')); // property should not exist in object scope
        $this->assertTrue($class->meta()->hasAttribute('extra_attr')); // property should exist in meta scope

        $this->assertEquals('This is meta extra attribute', $class->meta()->extra_attr);
    }

    public function testMetaInit()
    {
        $class = new ModelWithInit;

        $this->assertTrue($class->meta()->hasAttribute('init_attribute'));
        $this->assertInternalType('array', $class->meta()->init_attribute);
        $this->assertTrue($class->meta()->init_attribute['init']);
    }

    public function testCustomMetaClass()
    {
        $class = new ModelWithComponent;

        $this->assertSame(MetaTestClass::class, get_class($class->meta()));
        $this->assertTrue($class->meta()->hasAttribute('component'));

        $this->assertEquals('test', $class->meta()->component['env']);
        $this->assertEquals('Component', $class->meta()->component['name']);
    }
}
