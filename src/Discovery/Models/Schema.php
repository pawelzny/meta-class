<?php

namespace Pawelzny\Discovery\Models;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Discovery\Services\UnknownConnection;
use Pawelzny\MetaClass\Discovery\Contracts\SchemaDiscoverable;


class Schema extends Discovery implements SchemaDiscoverable
{
    /**
     * @var null|Connectable
     */
    protected $connection = null;
    /**
     * @var null|AbstractSchemaManager
     */
    protected $schema = null;

    /**
     * Schema constructor.
     * @param $class
     * @param Connectable $connection
     */
    public function __construct($class, Connectable $connection)
    {
        parent::__construct($class);

        $this->connection = $connection;
        if ($this->isKnownConnection() && $this->isEstablishedConnection()) {
            $this->schema = $this->connection->connect()->getSchemaManager();
        }
    }

    /**
     * Returns array of model schema columns.
     * If there is no connection to database or
     * can't sniff schema, returns null.
     * @return array|null
     */
    public function getModelFields()
    {
        $fields = null;
        try {
            $fields = $this->schema->listTableColumns($this->class->getTable());
        } catch (\Exception $exception) {}

        return $fields;
    }

    /**
     * Predicates if connection is known one
     * @return bool
     */
    protected function isKnownConnection()
    {
        $c = get_class($this->connection);

        return $c::NAME != UnknownConnection::NAME;
    }

    /**
     * Predicates if connection can be established
     * @return bool
     */
    protected function isEstablishedConnection()
    {
        return ! is_null($this->connection->connect());
    }
}