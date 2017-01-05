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
        if (! is_null($this->connection->connect())) {
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
        if ($this->connection instanceof UnknownConnection) {
            return null;
        }
        switch ($this->environment->name) {
            case 'laravel/framework':
                return $this->laravelModel();
            default:
                return $this->customModel();
        }
    }

    /**
     * @return array
     */
    protected function laravelModel()
    {
        $fields = $this->schema->listTableColumns($this->class->getTable());

        $guarded = $this->class->getGuarded();
        if (count($guarded) > 1 && ! in_array('*', $guarded)) {
            $filter = function ($field) {
                return ! in_array($field->getName(), $this->class->getGuarded()) &&
                    ! in_array($field->getName(), $this->class->getHidden());
            };
        } else {
            $filter = function ($field) {
                return in_array($field->getName(), $this->class->getFillable()) &&
                    ! in_array($field->getName(), $this->class->getHidden());
            };
        }

        return array_filter($fields, $filter);
    }

    /**
     * @return array
     */
    protected function customModel()
    {
        return $this->schema->listTableColumns($this->class->getTable());
    }
}