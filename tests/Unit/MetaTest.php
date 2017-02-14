<?php

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaClassException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;
use Pawelzny\MetaClass\Meta;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    public function testMetaAttributeSetter()
    {
        $meta = new Meta;
        $meta->testAttribute = 'test attribute';

        $this->assertFalse(property_exists($meta, 'testAttribute'));
        $this->assertEquals('test attribute', $meta->testAttribute);
    }

    public function testMetaMethodSetter()
    {
        $meta = new Meta;
        $meta->testMethod = function () {
            return 'test method';
        };

        $this->assertFalse(method_exists($meta, 'testMethod'));
        $this->assertEquals('test method', $meta->testMethod());
    }

    public function testHasAttribute()
    {
        $meta = new Meta;
        $meta->testAttribute = 'test attribute';

        $this->assertTrue($meta->hasAttribute('testAttribute'));
        $this->assertFalse($meta->hasAttribute('fakeAttribute'));
    }

    public function testHasMethod()
    {
        $meta = new Meta;
        $meta->testMethod = function () {
            return 'I am test method';
        };

        $this->assertTrue($meta->hasMethod('testMethod'));
        $this->assertEquals('I am test method', $meta->testMethod());

        $this->assertFalse($meta->hasMethod('fakeMethod'));
    }

    public function testMetaAttributeException()
    {
        $this->expectException(MetaAttributeException::class);

        $meta = new Meta;
        $meta->not_defiend_attr;
    }

    public function testMetaMethodException()
    {
        $this->expectException(MetaMethodException::class);

        $meta = new Meta;
        $meta->not_defiend_method();
    }

    public function testMetaClassException()
    {
        $this->expectException(MetaClassException::class);

        $meta = new Meta;
        $meta->something_wrong();
    }
}
