<?php

namespace Pawelzny\MetaClass\Contracts;

interface MetaComposable
{
    /**
     * Compose meta features from declared components
     * @return void
     */
    public function compose();
}
