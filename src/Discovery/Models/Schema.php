<?php

namespace Pawelzny\Discovery\Models;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Discovery\Contracts\SchemaDiscoverable;
use Pawelzny\Monads\Maybe;

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
        (new Maybe($this->connection))
            ->bind(function () {
                return $this->connection->connect();
            })
            ->bind(function ($conn) {
                $this->schema = $conn->getSchemaManager();
            });
    }

    /**
     * Returns array of model schema columns.
     * If there is no connection to database or
     * can't sniff schema, returns null.
     * @return array|null
     */
    public function getModelFields()
    {
        return (new Maybe($this->schema))->bind(function ($schema) {
            return $schema->listTableColumns($this->class->getTable());
        })->extract();
    }
}
