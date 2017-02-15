<?php

use Pawelzny\MetaClass\MetaModel;
use Pawelzny\Tests\Repository\Model\Model;
use PHPUnit\Framework\TestCase;

class MetaModelTest extends TestCase
{
    public function testModelSetter()
    {
        $model = new Model;
        $meta = new MetaModel($model);

        $class = new ReflectionClass($meta);
        $property = $class->getProperty('model');
        $property->setAccessible(true);

        $this->assertEquals(Model::class, get_class($property->getValue($meta)));
    }

    public function testModelSetterMethod()
    {
        $model = new Model;
        $meta = new MetaModel;

        $meta->setModel($model);

        $class = new ReflectionClass($meta);
        $property = $class->getProperty('model');
        $property->setAccessible(true);

        $this->assertEquals(Model::class, get_class($property->getValue($meta)));
    }
}
