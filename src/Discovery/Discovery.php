<?php namespace Pawelzny\Discovery;

class Discovery
{
    protected $conn;
    protected $sm;

    private static $instance = null;

    private function __construct()
    {
        // TODO: unhardcode to be available outside of Laravel
        $db = config('database.connections')[config('database.default')];

        $connectionParams = array(
            'dbname' => $db['database'],
            'user' => $db['username'],
            'password' => $db['password'],
            'host' => $db['host'],
            'driver' => "pdo_{$db['driver']}",
        );
        $config = new \Doctrine\DBAL\Configuration();

        $this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        $this->sm = $this->conn->getSchemaManager();
    }

    public static function Schema()
    {
        return static::instance()->sm;
    }

    public static function Connection()
    {
        return static::instance()->conn;
    }

    private static function instance()
    {
        if (static::$instance === null) {
            static::$instance = new Discovery();
        }

        return static::$instance;
    }
}