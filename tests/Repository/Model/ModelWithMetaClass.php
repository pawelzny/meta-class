<?php

namespace Pawelzny\Tests\Repository\Model;

use Pawelzny\MetaClass\MetaClass;

/**
 * Class ModelWithMetaClass
 * @package Pawelzny\Tests\Repository\Model
 */
class ModelWithMetaClass extends Model
{
    use MetaClass;

    public $name = 'Model with MetaClass';
}
