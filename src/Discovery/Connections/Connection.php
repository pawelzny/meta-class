<?php

namespace Pawelzny\Discovery\Connections;

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
     * @param array $db_credentials ['dbname', 'user', 'password', 'host', 'port', 'driver']
     */
    public function __construct(array $db_credentials = [])
    {
        $credentials = $this->getCredentials();
        foreach ($credentials as $key => $value) {
            if (array_key_exists($key, $db_credentials)) {
                $credentials[$key] = $db_credentials[$key];
            }
        }

        $hasCredentials = function () use ($credentials) {
            return count($credentials) == 6 ? $credentials : null;
        };

        $getConnection = function () use ($credentials) {
            try {
                return DriverManager::getConnection($credentials, new Configuration());
            } catch (\Exception $exception) {
                /** Could not get connection */
            }

            return null;
        };
        $maybe = new Maybe($this::NAME);
        $this->connection = $maybe->then($hasCredentials)->then($getConnection)->extract();
    }

    /**
     * @return Connectable|null
     */
    public function connect()
    {
        return $this->connection;
    }

    /**
     * @return array ['dbname', 'user', 'password', 'host', 'port', 'driver']
     */
    abstract protected function getCredentials();
}
