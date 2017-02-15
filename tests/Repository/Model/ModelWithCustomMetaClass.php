<?php

namespace Pawelzny\Tests\Repository\Model;

use Pawelzny\MetaClass\MetaClass;
use Pawelzny\Tests\Repository\Component\CustomMetaClass;

/**
 * Class ModelWithCustomMetaClass
 * @package Pawelzny\Tests\Repository\Model
 */
class ModelWithCustomMetaClass extends Model
{
    use MetaClass;

    public $name = 'Model with Component';

    protected $meta_class = CustomMetaClass::class;
}
