<?php

use Pawelzny\MetaClass\MetaModel;
use Pawelzny\Tests\Repository\Model\Model;
use Pawelzny\Tests\Repository\Model\ModelWithInitMethod;
use PHPUnit\Framework\TestCase;

class MetaModelTest extends TestCase
{
    public function testModelSetter()
    {
        $model = new Model;
        $meta = new MetaModel($model);

        $property = $this->getProtectedProperty($meta, 'model');
        $this->assertEquals(Model::class, get_class($property->getValue($meta)));

        // try to reset model instance
        $model_2 = new ModelWithInitMethod;
        $meta->setModel($model_2); // should not work. model has already been set

        $property = $this->getProtectedProperty($meta, 'model');
        $this->assertNotEquals(ModelWithInitMethod::class, get_class($property->getValue($meta)));
    }

    public function testModelSetterMethod()
    {
        $model = new Model;
        $meta = new MetaModel;

        // set model for the first time
        $meta->setModel($model);

        $property = $this->getProtectedProperty($meta, 'model');
        $this->assertEquals(Model::class, get_class($property->getValue($meta)));
    }

    private function getProtectedProperty($class, $property)
    {
        $class = new ReflectionClass($class);
        $property = $class->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }
}
