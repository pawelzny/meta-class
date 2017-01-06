<?php

use Pawelzny\Discovery\Traits\SchemaDiscovery;
use Pawelzny\MetaClass\Traits\MetaClass;

include ('vendor/autoload.php');

class Model
{
    use MetaClass, SchemaDiscovery;

//    protected $meta_connection;

    public function metaInit()
    {
        $this->meta()->test = true;
    }
}

$model = new Model;

echo "model: \r\n";
var_dump($model);
echo "meta: \r\n";
var_dump($model->meta());
