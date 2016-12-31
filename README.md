# MetaClass

Framework agnostic MetaClass support for PHP Classes.

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