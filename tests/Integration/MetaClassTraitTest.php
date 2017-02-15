<?php

use Pawelzny\MetaClass\MetaCompose;
use Pawelzny\Tests\Repository\Component\Component;
use Pawelzny\Tests\Repository\Component\CustomMetaClass;
use Pawelzny\Tests\Repository\Model\ModelWithCustomMetaClass;
use Pawelzny\Tests\Repository\Model\ModelWithInitMethod;
use Pawelzny\Tests\Repository\Model\ModelWithMetaClass;
use PHPUnit\Framework\TestCase;

class MetaClassTraitTest extends TestCase
{
    /**
     * Test Model with MetaClass trait, and no further customization.
     * MetaCompose is default meta class.
     */
    public function testModelWithMetaClass()
    {
        $class = new ModelWithMetaClass;

        // check for default meta class
        $this->assertSame(MetaCompose::class, get_class($class->meta()));

        // properties should not exist in meta scope
        $this->assertFalse($class->meta()->hasAttribute('extra_attr'));
        $this->assertFalse($class->meta()->hasMethod('extra_method'));

        // create new meta attribute and method
        $class->meta()->custom_meta_attr = "This is custom meta attribute";
        $class->meta()->custom_meta_method = function () {
            return "This is custom meta method";
        };

        // properties should not exist in object scope
        $this->assertFalse(property_exists($class, 'custom_meta_attr'));
        $this->assertFalse(property_exists($class, 'custom_meta_method'));
        // properties should exist in meta scope
        $this->assertTrue($class->meta()->hasAttribute('custom_meta_attr'));
        $this->assertTrue($class->meta()->hasMethod('custom_meta_method'));

        $this->assertEquals('This is custom meta attribute', $class->meta()->custom_meta_attr);
        $this->assertEquals('This is custom meta method', $class->meta()->custom_meta_method());
    }

    /**
     * Test Model with MetaClass trait, and no further customization.
     * Model has defined metaInit() method which is invoke once after meta object creating.
     */
    public function testMetaInit()
    {
        $class = new ModelWithInitMethod;

        $this->assertTrue($class->meta()->hasAttribute('init_attribute'));
        $this->assertInternalType('array', $class->meta()->init_attribute);
        $this->assertTrue($class->meta()->init_attribute['init']);
    }

    /**
     * Test Model with MetaClass trait, and CustomMetaClass model instead of default MetaCompose.
     * CustomMetaClass has one Component class which is executed on meta object initialization.
     */
    public function testCustomMetaClass()
    {
        $class = new ModelWithCustomMetaClass;

        $this->assertSame(CustomMetaClass::class, get_class($class->meta()));
        $this->assertTrue($class->meta()->hasAttribute('component'));

        $this->assertEquals('test', $class->meta()->component['env']);
        $this->assertEquals(Component::class, $class->meta()->component['name']);
    }
}
