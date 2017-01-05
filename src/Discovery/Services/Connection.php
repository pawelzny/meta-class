<?php

namespace Pawelzny\Discovery\Services;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Pawelzny\Discovery\Contracts\Connectable;

abstract class Connection implements Connectable
{
    const MYSQL_DRIVER = 'pdo_mysql';
    const POSTGRES_DRIVER = 'pdo_pgsql';
    const SQLITE_DRIVER = 'pdo_sqlite';
    const MS_SQL_DRIVER = 'sqlsrv';
    const ORACLE_DRIVER = 'oci8';

    protected $connection = null;

    public function __construct($db_name = null, $db_user = null, $db_pass = null,
                                $db_host = null, $db_port = null, $db_driver = null)
    {
        $db_params = [
            'dbname' => $db_name,
            'user' => $db_user,
            'password' => $db_pass,
            'host' => $db_host,
            'port' => $db_port,
            'driver' => $db_driver,
        ];

        $config = new Configuration();
        if ($this->connection === null) {
            $this->connection = DriverManager::getConnection($db_params, $config);
        }
    }

    public function connect()
    {
        return $this->connection;
    }
}
