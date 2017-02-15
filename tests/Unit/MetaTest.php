<?php

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaClassException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;
use Pawelzny\MetaClass\Meta;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    protected $meta;

    public function setUp()
    {
        parent::setUp();

        $this->meta = new Meta;
        $this->meta->test_attribute = 'test attribute';
        $this->meta->testMethod = function () {
            return 'test method';
        };
    }

    public function testMetaAttributeSetter()
    {
        $this->assertFalse(property_exists($this->meta, 'test_attribute'));
        $this->assertEquals('test attribute', $this->meta->test_attribute);
    }

    public function testMetaMethodSetter()
    {
        $this->assertFalse(method_exists($this->meta, 'testMethod'));
        $this->assertEquals('test method', $this->meta->testMethod());
    }

    public function testHasAttribute()
    {
        $this->assertTrue($this->meta->hasAttribute('test_attribute'));
        $this->assertFalse($this->meta->hasAttribute('fake_attribute'));
    }

    public function testHasMethod()
    {
        $this->assertTrue($this->meta->hasMethod('testMethod'));
        $this->assertEquals('test method', $this->meta->testMethod());

        $this->assertFalse($this->meta->hasMethod('fakeMethod'));
    }

    public function testMetaAttributeException()
    {
        $this->expectException(MetaAttributeException::class);
        $this->meta->not_defiend_attr;
    }

    public function testMetaMethodException()
    {
        $this->expectException(MetaMethodException::class);
        $this->meta->notDefiendMethod();
    }

    public function testMetaClassException()
    {
        $this->expectException(MetaClassException::class);
        $this->meta->somethingWrong();
    }
}
