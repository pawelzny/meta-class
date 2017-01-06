<?php

namespace Pawelzny\Monads;

class MaybeNot extends Maybe
{
    protected function maybe()
    {
        return ! parent::maybe();
    }
}
