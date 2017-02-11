<?php

require_once "Component.php";

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\MetaCompose;

class MetaTestClass extends MetaCompose implements Composable
{
    protected $components = [Component::class];
    protected $args = ['env' => 'test'];
}
