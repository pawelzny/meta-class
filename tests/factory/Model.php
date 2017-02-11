<?php

require_once "MetaTestClass.php";

class Model
{
    public $name = 'Test Model';
}

class ModelWithTrait extends Model
{
    use \Pawelzny\MetaClass\MetaClass;
}

class ModelWithComponent extends Model
{
    use \Pawelzny\MetaClass\MetaClass;

    protected $meta_class = MetaTestClass::class;
}

class ModelWithInit extends Model
{
    use \Pawelzny\MetaClass\MetaClass;

    protected function metaInit()
    {
        $this->meta()->init_attribute = ['init' => true];
    }
}
