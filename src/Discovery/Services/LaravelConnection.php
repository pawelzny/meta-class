<?php

namespace Pawelzny\Discovery\Services;

use Pawelzny\Discovery\Contracts\Connectable;

class LaravelConnection extends Connection implements Connectable
{
    public function __construct()
    {
        $db = \config('database.connections')[\config('database.default')];
        parent::__construct($db['database'], $db['username'], $db['password'],
                            $db['host'], $db['port'], Connection::MYSQL_DRIVER);
    }
}
