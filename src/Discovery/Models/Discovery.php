<?php namespace Pawelzny\Discovery\Models;

use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Discovery\Services\Environment;

class Discovery
{
    protected $class;
    protected $connection;
    protected $schema;
    protected $environment;

    public function __construct($class, Connectable $connection)
    {
        $this->class = $class;
        $this->connection = $connection;
        $this->schema = $this->connection->connect()->getSchemaManager();
        $this->environment = new Environment();
    }

    public function setMetaFields()
    {
        switch ($this->environment) {
            case 'laravel/framework':
                $this->laravelModel();
                break;
            default:
                $this->defaultModel();
        }
    }

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

        $this->class->meta()->fields = array_filter($fields, $filter);
    }

    protected function defaultModel()
    {
        $this->class->meta()->fields = $this->schema->listTableColumns($this->class->getTable());
    }
}
