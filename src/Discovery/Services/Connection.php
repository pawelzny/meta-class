<?php

namespace Pawelzny\Discovery\Services;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Monads\Maybe;

abstract class Connection implements Connectable
{
    /** Available database drivers */
    const MYSQL_DRIVER = 'pdo_mysql';
    const POSTGRES_DRIVER = 'pdo_pgsql';
    const SQLITE_DRIVER = 'pdo_sqlite';
    const MS_SQL_DRIVER = 'sqlsrv';
    const ORACLE_DRIVER = 'oci8';

    /**
     * @const string Name of current used db_connection
     */
    const NAME = 'generic';

    /**
     * @var Connectable|null
     */
    protected $connection = null;

    /**
     * Connection constructor.
     * @param $db_name
     * @param $db_user
     * @param $db_pass
     * @param $db_host
     * @param $db_port
     * @param $db_driver
     */
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

        $getConnection = function () use ($db_params) {
            try {
                return DriverManager::getConnection($db_params, new Configuration());
            } catch (\Exception $exception) {
                /** Could not get connection */
            }

            return null;
        };
        $maybe = new Maybe($this::NAME);
        $this->connection = $maybe->then($getConnection)->extract();
    }

    /**
     * @return Connectable|null
     */
    public function connect()
    {
        return $this->connection;
    }
}
