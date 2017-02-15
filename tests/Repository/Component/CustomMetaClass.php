<?php

namespace Pawelzny\Tests\Repository\Component;

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\MetaCompose;

/**
 * Class CustomMetaClass
 * @package Pawelzny\Tests\Repository\Component
 */
class CustomMetaClass extends MetaCompose implements Composable
{
    protected $components = [Component::class];
    protected $args = ['env' => 'test'];
}
