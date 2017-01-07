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
     * @param $model
     * @param Connectable $connection
     */
    public function __construct($model, Connectable $connection)
    {
        parent::__construct($model);

        $getSchemaManager = function ($connection) {
            return $connection->getSchemaManager();
        };

        $this->connection = $connection;
        $maybe = new Maybe($this->connection);
        $this->schema = $maybe->then($maybe($this->connection->connect()))
                              ->then($maybe($getSchemaManager))->extract();
    }

    /**
     * Returns array of model schema columns.
     * If there is no connection to database or
     * can't sniff schema, returns null.
     * @return array|null
     */
    public function getModelFields()
    {
        $listTableColumns = function ($table) {
            return $this->schema->listTableColumns($table);
        };
        $maybe = new Maybe($this->schema);

        return $maybe->then($maybe($this->model->getTable()))
                     ->then($maybe($listTableColumns))->extract();
    }
}
