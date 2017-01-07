<?php

namespace Pawelzny\Discovery\Services;

use Pawelzny\Discovery\Contracts\Connectable;

class UnknownConnection extends Connection implements Connectable
{
    /**
     * @const null
     */
    const NAME = null;

    /**
     * UnknownConnection constructor.
     */
    public function __construct()
    {
        parent::__construct($db_name = null, $db_user = null, $db_pass = null,
                            $db_host = null, $db_port = null, $db_driver = null);
    }
}
