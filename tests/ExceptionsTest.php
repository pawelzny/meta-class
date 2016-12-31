<?php

use Pawelzny\MetaClass\Exceptions\ForbiddenException;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    public function testForbiddenException()
    {
        $property = 'meta';
        try {
            throw new ForbiddenException($property);
        } catch (ForbiddenException $exception) {
            $this->assertInstanceOf('\Pawelzny\MetaClass\Exceptions\ForbiddenException', $exception);
            $this->assertEquals("Forbidden direct assignment to property: $property", $exception->getMessage());
        }
    }

    public function testMetaAttributeException()
    {
        $attribute = 'undefined_attribute';
        try {
            throw new MetaAttributeException($attribute);
        } catch (MetaAttributeException $exception) {
            $this->assertInstanceOf('\Pawelzny\MetaClass\Exceptions\MetaAttributeException', $exception);
            $this->assertEquals("Undefined meta attribute: $attribute", $exception->getMessage());
        }
    }

    public function testMetaMethodException()
    {
        $method = 'undefined_method';
        try {
            throw new MetaMethodException($method);
        } catch (MetaMethodException $exception) {
            $this->assertInstanceOf('\Pawelzny\MetaClass\Exceptions\MetaMethodException', $exception);
            $this->assertEquals("Undefined meta method: $method", $exception->getMessage());
        }
    }
}
