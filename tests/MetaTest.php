<?php

use Pawelzny\MetaClass\Models\Meta;
use PHPUnit\Framework\TestCase;

class MetaClassTest extends TestCase
{
    protected $meta;

    public function setUp()
    {
        parent::setUp();

        $class = new \stdClass();
        $class->name = 'test class';

        $this->meta = new Meta($class);
    }

    public function testConstructor()
    {
        $meta_class = new ReflectionClass($this->meta);
        $property = $meta_class->getProperty('class');
        $property->setAccessible(true);
        $std_class = $property->getValue($this->meta);
        $this->assertInstanceOf('stdClass', $std_class);
        $this->objectHasAttribute('name', $std_class);
    }

    public function testSetMethod()
    {
        $this->meta->test_method = function () {
            return true;
        };

        $class = new ReflectionClass($this->meta);
        $property = $class->getProperty('methods');
        $property->setAccessible(true);
        $this->assertArrayHasKey('test_method', $property->getValue($this->meta));
    }

    public function testSetAttribute()
    {
        $this->meta->test_attribute = ['test' => true];

        $class = new ReflectionClass($this->meta);
        $property = $class->getProperty('attributes');
        $property->setAccessible(true);
        $this->assertArrayHasKey('test_attribute', $property->getValue($this->meta));
    }

    public function testCallMethod()
    {
        $this->meta->test_method = function () {
            return ['test' => true];
        };

        $this->assertInternalType('array', $this->meta->test_method());
        $this->assertArrayHasKey('test', $this->meta->test_method());
    }

    /**
     * @expectedException \Pawelzny\MetaClass\Exceptions\MetaMethodException
     */
    public function testCallUndefinedMethod()
    {
        $this->meta->undefined_method();
    }

    public function testGetAttribute()
    {
        $this->meta->test_attribute = ['test' => true];

        $this->assertArrayHasKey('test', $this->meta->test_attribute);
    }

    /**
     * @expectedException \Pawelzny\MetaClass\Exceptions\MetaAttributeException
     */
    public function testGetUndefinedAttribute()
    {
        $this->meta->undefined_attribute;
    }

    public function testHasAttribute()
    {
        $this->meta->test_attribute = 'test';

        $this->assertTrue($this->meta->hasAttribute('test_attribute'));
        $this->assertFalse($this->meta->hasAttribute('undefined_attribute'));
    }

    public function testHasMethod()
    {
        $this->meta->test_method = function () {
            return ['test' => true];
        };

        $this->assertTrue($this->meta->hasMethod('test_method'));
        $this->assertFalse($this->meta->hasMethod('undefined_method'));
    }
}
