<?php

use Pawelzny\MetaClass\MetaClass;
use Pawelzny\MetaClass\Model\Meta;
use PHPUnit\Framework\TestCase;

class Metator
{
    use MetaClass;
}

class MetatorInit
{
    use MetaClass;

    // override default initMeta method to set initial, custom meta attribute
    public function metaInit()
    {
        $this->meta()->init_attribute = ['init' => true];
    }
}

class MetaClassTraitTest extends TestCase
{
    protected $metator;
    protected $metatorInit;

    public function setUp()
    {
        parent::setUp();

        $this->metator = new Metator();
        $this->metatorInit = new MetatorInit();
    }

    public function testMetatorAccessMeta()
    {
        $this->assertInstanceOf(Meta::class, $this->metator->meta());
        $this->assertInstanceOf(Meta::class, $this->metatorInit->meta());
    }

    public function testMetaInit()
    {
        $this->assertFalse($this->metator->meta()->hasAttribute('init_attribute'));
        $this->assertTrue($this->metatorInit->meta()->hasAttribute('init_attribute'));
        $this->assertInternalType('array', $this->metatorInit->meta()->init_attribute);
    }
}
