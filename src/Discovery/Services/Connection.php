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

    protected $db_name = null;
    protected $db_user = null;
    protected $db_pass = null;
    protected $db_host = null;
    protected $db_port = null;
    protected $db_driver = null;
    protected $connection = null;

    public function __construct($db_name = null, $db_user = null, $db_pass = null,
                                $db_host = null, $db_port = null, $db_driver = null)
    {
        $this->setName($db_name)
             ->setUser($db_user)
             ->setPass($db_pass)
             ->setHost($db_host)
             ->setPort($db_host)
             ->setDriver($db_driver);
    }

    public function setName($value)
    {
        if ($value) {
            $this->db_name = $value;
        }

        return $this;
    }

    public function setUser($value)
    {
        if ($value) {
            $this->db_user = $value;
        }

        return $this;
    }

    public function setPass($value)
    {
        if ($value) {
            $this->db_pass = $value;
        }

        return $this;
    }

    public function setHost($value)
    {
        if ($value) {
            $this->db_host = $value;
        }

        return $this;
    }

    public function setPort($value)
    {
        if ($value) {
            $this->db_port = $value;
        }

        return $this;
    }

    public function setDriver($value)
    {
        if ($value) {
            $this->db_driver = $value;
        }

        return $this;
    }

    public function connect()
    {
        $db_params = [
            'dbname' => $this->db_name,
            'user' => $this->db_user,
            'password' => $this->db_pass,
            'host' => $this->db_host,
            'port' => $this->db_port,
            'driver' => $this->db_driver,
        ];

        $config = new Configuration();

        if ($this->connection === null) {
            $this->connection = DriverManager::getConnection($db_params, $config);
        }

        return $this->connection;
    }
}
