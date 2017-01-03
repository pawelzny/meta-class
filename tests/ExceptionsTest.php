<?php

use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    public function testMetaAttributeException()
    {
        $attribute = 'undefined_attribute';
        try {
            throw new MetaAttributeException($attribute);
        } catch (MetaAttributeException $exception) {
            $this->assertInstanceOf(MetaAttributeException::class, $exception);
            $this->assertEquals("Undefined meta attribute: $attribute", $exception->getMessage());
        }
    }

    public function testMetaMethodException()
    {
        $method = 'undefined_method';
        try {
            throw new MetaMethodException($method);
        } catch (MetaMethodException $exception) {
            $this->assertInstanceOf(MetaMethodException::class, $exception);
            $this->assertEquals("Undefined meta method: $method", $exception->getMessage());
        }
    }
}
