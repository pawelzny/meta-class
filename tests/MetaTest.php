<?php

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
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
    }

    public function testMetaAttributeSetter()
    {
        $this->meta->testAttribute = 'test attribute';

        $this->assertFalse(property_exists($this->meta, 'testAttribute'));
        $this->assertEquals('test attribute', $this->meta->testAttribute);
    }

    public function testMetaMethodSetter()
    {
        $this->meta->testMethod = function () {
            return 'test method';
        };

        $this->assertFalse(method_exists($this->meta, 'testMethod'));
        $this->assertEquals('test method', $this->meta->testMethod());
    }

    public function testHasAttribute()
    {
        $this->meta->testAttribute = 'test attribute';

        $this->assertTrue($this->meta->hasAttribute('testAttribute'));
        $this->assertFalse($this->meta->hasAttribute('fakeAttribute'));
    }

    public function testHasMethod()
    {
        $this->meta->testMethod = function () {
            return 'I am test method';
        };

        $this->assertTrue($this->meta->hasMethod('testMethod'));
        $this->assertEquals('I am test method', $this->meta->testMethod());

        $this->assertFalse($this->meta->hasMethod('fakeMethod'));
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
}
