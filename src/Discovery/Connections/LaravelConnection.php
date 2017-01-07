<?php

namespace Pawelzny\Discovery\Connections;

use Pawelzny\Discovery\Contracts\Connectable;

/**
 * Class LaravelConnection
 *
 * This is default LaravelConnection adapter class needed for
 * Pawelzny\Discovery\Traits\SchemaDiscovery module.
 *
 * If you are using other than default connections naming convention
 * You should extend this class and override:
 * $connection_name or/and $available_drivers
 *
 * @package Pawelzny\Discovery\Connections
 */
class LaravelConnection extends Connection implements Connectable
{
    /**
     * Identifier of this Connection adapter
     * @const string
     */
    const NAME = 'laravel';

    /**
     * Config Database Connection Name
     * @var string
     */
    protected $db_connection_name = 'database.default';

    /**
     * Config Database connections table
     * @var string
     */
    protected $db_connections = 'database.connections';

    /**
     * List of default laravel drivers
     * matching available Symfony\DBAL drivers
     * @var array
     */
    protected $available_drivers = [
        'sqlite' => Connection::SQLITE_DRIVER,
        'mysql' => Connection::MYSQL_DRIVER,
        'pgsql' => Connection::POSTGRES_DRIVER,
        'ms_sql' => Connection::MS_SQL_DRIVER,
        'oracle' => Connection::ORACLE_DRIVER,
    ];

    /**
     * @return array ['dbname', 'user', 'password', 'host', 'port', 'driver']
     */
    protected function getCredentials()
    {
        $db = config($this->db_connections)[config($this->db_connection_name)];

        return [
            'dbname' => $db['database'],
            'user' => $db['username'],
            'password' => $db['password'],
            'host' => $db['host'],
            'port' => $db['port'],
            'driver' => $this->available_drivers[$db['driver']],
        ];
    }
}
