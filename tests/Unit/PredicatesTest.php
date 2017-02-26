<?php

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Meta;
use Pawelzny\MetaClass\MetaCompose;
use Pawelzny\Support\Predication;
use PHPUnit\Framework\TestCase;

class PredicatesTest extends TestCase
{
    public function testHasInterface()
    {
        $this->assertTrue(Predication\hasInterface(new MetaCompose, Composable::class));
        $this->assertFalse(Predication\hasInterface(new Meta, Composable::class));
    }
}
