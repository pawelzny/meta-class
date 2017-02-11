<?php

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Meta;
use Pawelzny\MetaClass\MetaCompose;
use PHPUnit\Framework\TestCase;
use Pawelzny\Support;

class PredicateTest extends TestCase
{
    public function testHasInterface()
    {
        $this->assertTrue(Support\hasInterface(new MetaCompose, Composable::class));
        $this->assertFalse(Support\hasInterface(new Meta, Composable::class));
    }
}
