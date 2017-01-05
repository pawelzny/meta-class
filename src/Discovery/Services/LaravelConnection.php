<?php

namespace Pawelzny\Discovery\Services;

use Pawelzny\Discovery\Contracts\Connectable;

class LaravelConnection extends Connection implements Connectable
{
    public function __construct()
    {
        $db = config('database.connections')[config('database.default')];
        $db['driver'] = "pdo_{$db['driver']}";

        parent::__construct($db['database'], $db['username'], $db['password'],
                            $db['host'], $db['port'], $db['driver']);
    }
}
