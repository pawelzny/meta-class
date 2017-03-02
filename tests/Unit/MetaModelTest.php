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

        $model_2 = new ModelWithInitMethod; // try to reset model instance
        $meta->setModel($model_2); // should not work. model has already been set

        $this->assertEquals(Model::class, get_class($meta->getModel()));
        $this->assertNotEquals(ModelWithInitMethod::class, $meta->getModel());
    }

    public function testModelSetterMethod()
    {
        $model = new Model;
        $meta = new MetaModel;

        // set model for the first time
        $meta->setModel($model);

        $this->assertEquals(Model::class, get_class($meta->getModel()));
    }
}
