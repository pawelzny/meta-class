<?php

namespace Pawelzny\Discovery\Services;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Monads\Maybe;
use Pawelzny\Monads\MaybeNot;

abstract class Connection implements Connectable
{
    const MYSQL_DRIVER = 'pdo_mysql';
    const POSTGRES_DRIVER = 'pdo_pgsql';
    const SQLITE_DRIVER = 'pdo_sqlite';
    const MS_SQL_DRIVER = 'sqlsrv';
    const ORACLE_DRIVER = 'oci8';

    const NAME = 'generic';

    protected $connection = null;

    public function __construct($db_name, $db_user, $db_pass, $db_host, $db_port, $db_driver)
    {
        $db_params = [
            'dbname' => $db_name,
            'user' => $db_user,
            'password' => $db_pass,
            'host' => $db_host,
            'port' => $db_port,
            'driver' => $db_driver,
        ];

        (new Maybe($this::NAME))->bind(function () use ($db_params) {
            (new MaybeNot($this->connection))->bind(function () use ($db_params) {
                $this->connection = DriverManager::getConnection($db_params, new Configuration());
            });
        });
    }

    public function connect()
    {
        return $this->connection;
    }
}
