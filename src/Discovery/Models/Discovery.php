<?php namespace Pawelzny\Discovery\Models;


use Pawelzny\Discovery\Services\Schema;

class Discovery
{
    protected $class;
    protected $schema;
    protected $environment;

    protected $conn;
    protected $sm;

    protected $discoverable = [
        'schema', 'environment',
    ];

    public function __construct($class, $environment)
    {
        $this->class = $class;
        $this->environment = new $environment();
        $this->schema = new Schema($this->environment);

//        // TODO: unhardcode to be available outside of Laravel
//        $db = config('database.connections')[config('database.default')];
//
//        $connectionParams = [
//            'dbname' => $db['database'],
//            'user' => $db['username'],
//            'password' => $db['password'],
//            'host' => $db['host'],
//            'driver' => "pdo_{$db['driver']}",
//        ];
//        $config = new \Doctrine\DBAL\Configuration();
//
//        $this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
//        $this->sm = $this->conn->getSchemaManager();
    }

    /**
     * TODO: unhardcode to be available outside of Laravel
     */
//    private function setModelFields()
//    {
//        $fields = Discovery::Schema()->listTableColumns($this->class->getTable());
//
//        $guarded = $this->class->getGuarded();
//        if (count($guarded) > 1 && ! in_array('*', $guarded)) {
//            $filter = function ($field) {
//                return ! in_array($field->getName(), $this->class->getGuarded()) &&
//                    ! in_array($field->getName(), $this->class->getHidden());
//            };
//        } else {
//            $filter = function ($field) {
//                return in_array($field->getName(), $this->class->getFillable()) &&
//                    ! in_array($field->getName(), $this->class->getHidden());
//            };
//        }
//
//        $this->fields = array_map(function ($field) {
//            return $field->toArray();
//        }, array_filter($fields, $filter));
//    }
}
