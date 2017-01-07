<?php

namespace Pawelzny\Discovery\Connections;

use Pawelzny\Discovery\Contracts\Connectable;

class UnknownConnection extends Connection implements Connectable
{
    /**
     * @const null
     */
    const NAME = null;

    /**
     * @return array ['dbname', 'user', 'password', 'host', 'port', 'driver']
     */
    protected function getCredentials()
    {
        return [];
    }
}
