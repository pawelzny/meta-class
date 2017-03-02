<?php

use Pawelzny\MetaClass\Meta;
use PHPUnit\Framework\TestCase;

class StandaloneMetaTest extends TestCase
{
    public function testPassingSelfContext()
    {
        $meta = new Meta;

        $meta->setAttribute('multiplier', 2);
        $meta->setMethod('multiply', function ($a, $self) {
            return $a * $self->multiplier;
        });

        $this->assertEquals(4, $meta->multiply(2));
    }
}
