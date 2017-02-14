<?php

namespace Pawelzny\Tests\Repository\Model;

use Pawelzny\MetaClass\MetaClass;

/**
 * Class ModelWithInitMethod
 * @package Pawelzny\Tests\Repository\Model
 */
class ModelWithInitMethod extends Model
{
    use MetaClass;

    public $name = 'Model with init method';

    protected function metaInit()
    {
        $this->meta()->init_attribute = ['init' => true];
    }
}
