<?php

use Pawelzny\MetaClass\MetaClass;
use Pawelzny\MetaClass\MetaCompose;
use Pawelzny\MetaClass\MetaModel;
use PHPUnit\Framework\TestCase;

class MetaClassTraitTest extends TestCase
{
    public function testAccessMeta()
    {
        $class = new class() {
            use MetaClass;
        };

        $this->assertSame(MetaCompose::class, get_class($class->meta()));
        $this->assertFalse($class->meta()->hasAttribute('extra_attr')); // property should not exist in any scope

        $class->meta()->extra_attr = "This is meta extra attribute"; // create new meta attribute

        $this->assertFalse(property_exists($class, 'extra_attr')); // property should not exist in object scope
        $this->assertTrue($class->meta()->hasAttribute('extra_attr')); // property should exist in meta scope

        $this->assertEquals('This is meta extra attribute', $class->meta()->extra_attr);
    }

    public function testMetaInit()
    {
        $class = new class() {
            use MetaClass;

            public function metaInit()
            {
                $this->meta()->init_attribute = ['init' => true];
            }
        };

        $this->assertTrue($class->meta()->hasAttribute('init_attribute'));
        $this->assertInternalType('array', $class->meta()->init_attribute);
        $this->assertTrue($class->meta()->init_attribute['init']);
    }

    public function testCustomMetaClass()
    {
        $class = new class() {
            use MetaClass;

            protected $meta_class = MetaModel::class;
        };

        $this->assertSame(MetaModel::class, get_class($class->meta()));
        $this->assertNotSame(MetaCompose::class, get_class($class->meta()));
    }
}
