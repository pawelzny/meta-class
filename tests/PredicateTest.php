<?php

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Meta;
use Pawelzny\MetaClass\MetaCompose;
use Pawelzny\Support;
use PHPUnit\Framework\TestCase;

class PredicateTest extends TestCase
{
    public function testHasInterface()
    {
        $this->assertTrue(Support\hasInterface(new MetaCompose, Composable::class));
        $this->assertFalse(Support\hasInterface(new Meta, Composable::class));
    }
}
