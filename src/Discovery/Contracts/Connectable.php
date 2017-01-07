<?php

namespace Pawelzny\Discovery\Contracts;

interface Connectable
{
    /**
     * @return Connectable|null
     */
    public function connect();
}
