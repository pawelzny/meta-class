<?php

use Pawelzny\MetaClass\MetaModel;
use PHPUnit\Framework\TestCase;

class MetaClassTest extends TestCase
{
    protected $meta;

    public function setUp()
    {
        parent::setUp();
        // MetaClass consumes objects
        $this->meta = new MetaModel(new stdClass());
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
}
