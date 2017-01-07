# MetaClass

Framework agnostic MetaClass support for PHP Classes.

Gives model's ability to have meta attributes and meta methods,
which are encapsulate behind `meta()` API.

MetaClass built in extension `SchemaDiscover` is able to fetch
model schema columns. Can be useful when model is not aware of it's schema.

## Installation:

**If composer is installed globally in your OS:**
```
composer require pawelzny/meta-class
```

**If composer is installed locally in your project directory:**
```
php composer.phar require pawelzny/meta-class
```

## Get started

Use MetaClass Trait to enable meta methods and meta attributes.
For now on Class has access to public `$this->meta()` method which
gives access to meta attributes and meta methods.

Class has also access to protected `$this->initMeta()` method which
initialize meta attributes and methods once on init.

```php
<?php

use Pawelzny\MetaClass\Traits\MetaClass;

class Model {
    use MetaClass;
    
    /**
     * Optional hook invoked on MetaClass construction.
     */
    protected function initMeta()
    {
        $this->meta()->custom_init_attribute = 'init attribute';
        $this->meta()->custom_init_method = function () { return 'custom method'; };
    }
}
```

You can add new attributes and methods on runtime:

```php
<?php
$model = new Model();
$model->meta()->custom_meta_attribute = 'this is meta attribute';
$model->meta()->custom_meta_method = function () { return 'meta function'; };

assert($model->meta()->hasAttribute('custom_meta_attribute')); // true
assert($model->meta()->hasAttribute('custom_init_attribute')); // true

assert($model->meta()->hasMethod('custom_meta_method')); // true
assert($model->meta()->hasMethod('custom_init_method')); // true

assert($model->meta()->hasAttribute('undefined_attribute')); //false
assert($model->meta()->hasMethod('undefined_method')); // false
```

## Model schema columns autoload

If model is separated from schema id is difficult to manage automatic jobs
in example generating forms for administrative CRUD purposes.

Add another trait to model to fetch schema columns.

SchemaDiscovery uses `\Symfony\DBAL` library.

Schema columns are set as `meta()->fields` attribute.

### Requirements

* Your model have to implement database table name getter `getTable()`.
* Your model need `$meta_connection` property pointing to Connectable class.


```php
<?php

use Pawelzny\Discovery\Connections\Connection;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Discovery\Traits\SchemaDiscovery;
use Pawelzny\MetaClass\Traits\MetaClass;

class CustomConnection extends Connection implements Connectable
{
    /**
     * Connection adapter identifier.
     * Needs to be not empty string value.
     * @return string
     */
    const NAME = 'custom';
    
    /**
     * @return array ['dbname', 'user', 'password', 'host', 'port', 'driver']
     */
    protected function getCredentials()
    {
        /* 
         * get_config() function is just an example of how you should do this.
         * never use passwords with plain text in your source code under version control.
         */
        return [
            'dbname' => get_config('database'),
            'user' => get_config('username'),
            'password' => get_config('password'),
            'host' => get_config('host'),
            'port' => get_config('port'),
            'driver' => Connection::MYSQL_DRIVER,
        ];
    }
}

class Model {
    use MetaClass, SchemaDiscovery;
    
    protected $table = 'models';
    protected $meta_connection = CustomConnection::class;
    
    protected function initMeta()
    {
        $this->meta()->custom_init_attribute = 'init attribute';
        $this->meta()->custom_init_method = function () { return 'custom method'; };
    }
    
    /**
     * If your framework do not implements
     * database table getter you need to add it manually.
     */
    public function getTable()
    {
        return $this->table;
    }
}
```

### Predefined Connections

Use one of this predefined Connection adapters.

1. `\Pawelzny\Discovery\Services\LaravelConnection::class`

## MetaClass API

Access directly from class which uses MetaClass Trait.
```php
<?php

use Pawelzny\MetaClass\Traits\MetaClass;

class MyModel
{
    use MetaClass;
    
    public function getValue()
    {
        return $this->meta()->value;
    }
    
    protected function initMeta()
    {
        $this->meta()->value = 'initial value';
    }
}
```

### `MetaClass: meta()`

Gives access to MetaClass instance.

### `void: initMeta()`

Gives ability to initiate meta attributes and meta methods on MetaClass initialization.

## Meta API

Gives access through `meta()` interface.
```php
<?php

use Pawelzny\MetaClass\Traits\MetaClass;

class MyModel
{
    use MetaClass;
    
    public function hasValue()
    {
        return $this->meta()->hasAttribute('value');
    }
    
    public function hasMethod()
    {
        return $this->meta()->hasMethod('custom');
    }
    
    protected function initMeta()
    {
        $this->meta()->value = 'initial value';
        $this->meta()->custom = function () { return null; };
    }
}
```

### `boolean: hasAttribute(string $name)`

Checks if MetaClass instance has attribute

### `boolean: hasMethod(string $name)`

Checks if MetaClass instance has method
