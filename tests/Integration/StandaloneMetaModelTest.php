<?php

use Pawelzny\MetaClass\MetaModel;
use Pawelzny\Tests\Repository\Model\Model;
use PHPUnit\Framework\TestCase;

class StandaloneMetaModelTest extends TestCase
{
    public function testMetaMethodsArgsCount()
    {
        $meta = new MetaModel;

        $meta->defaultArgs = function () {
            return func_get_args();
        };
        $this->assertCount(1, $meta->defaultArgs());
        $this->assertSame($meta, $meta->defaultArgs()[0]);

        $meta->customArgs = function ($a, $b) {
            return func_get_args();
        };

        $this->assertCount(3, $meta->customArgs(1, 2));
        $this->assertEquals(1, $meta->customArgs(1, 2)[0]);
        $this->assertEquals(2, $meta->customArgs(1, 2)[1]);
        $this->assertSame($meta, $meta->customArgs(1, 2)[2]);
    }

    public function testModelDecoration()
    {
        $model = new Model;
        $meta = new MetaModel($model);

        // MetaModel is passing $this as last argument
        $meta->setMethod('funWithName', function ($self) {
            return 'This is decorated ' . $self->getModel()->name;
        });

        $this->assertEquals('Test Model', $model->name);
        $this->assertEquals('This is decorated Test Model', $meta->funWithName());

        $meta->setMethod('customArgs', function ($a, $b) {
            return func_get_args();
        });

        $this->assertCount(3, $meta->customArgs(1, 2));
        $this->assertEquals(1, $meta->customArgs(1, 2)[0]);
        $this->assertEquals(2, $meta->customArgs(1, 2)[1]);
        $this->assertSame($meta, $meta->customArgs(1, 2)[2]);
    }
}
