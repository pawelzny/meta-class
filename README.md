# MetaClass

Dependency free, framework agnostic MetaClass support for PHP Classes.
Easy to use encapsulation for meta data and meta methods.

**API Documentation** can be found at [https://pawelzny.com/meta-class/]()

Licensed under ISC condition Copyright (c) 2017, Paweł Zadrożny.

## What this package is

* PHP classes extension container for meta data and meta methods.
* Ability to perform actions on object which is not related to business logic.
* Ability to store information needed for automation application logic.
* Delegation of logic with extensible components composition.

## What this package is not

* This is no Python-like PHP extension used to redefine classes behaviour.
* Workaround for bad inheritance architecture.
* Another complex library which slows down application execution.

## Installation:

**If composer is installed globally in your OS:**
```
composer require pawelzny/meta-class
```

**If composer is installed locally in your project directory:**
```
php composer.phar require pawelzny/meta-class
```

# Get started

## Basic usage

Basic functionality is available thanks to single Trait implemented in your class.

```php
<?php

class User
{
    use \Pawelzny\MetaClass\MetaClass;
    
    // rest of your User Class
}
```

With MetaClass trait model gets access to `meta()` method which is an interface for meta data.
Using `meta()` interface is as easy as assigning values and closures to dynamic attributes.

```php
<?php

$user = new User;
$user->meta()->special_attribute = "I am so special!";
$user->meta()->secretMethod = function () {
    return 'shh .. I am secret!';
};
```

## Meta data initialization

MetaClass Trait gives access to another method `metaInit()` which is invoke once on MetaClass boot.
This is perfect place to initialize default values and methods.

```php
<?php

class User
{
    use \Pawelzny\MetaClass\MetaClass;
    
    protected function metaInit()
    {
        $this->meta()->booted_values = ['start_at' => microtime(true)];
    }
}

$user = new User;
echo $user->meta()->booted_values['start_at'];
```


# Advance Meta data with components

On default, MetaClass trait boot MetaCompose class which provides all basic
functionality. MetaCompose fits best for further extension.

## Create Component

Components could be use for more complex logic composition. 
Instead of putting all logic in metaInit, some parts should be encapsulated.

All components must implements Composable interface.
Which enforce implementation of three method:

* `compose()` used for computation process
* `with()` used as arguments setter
* `andReturn()` to return back computations


```php
<?php

use \Pawelzny\MetaClass\Contracts\Composable;

class CustomComponent implements Composable
{
    protected $args = [];
    protected $output;
    
    /**
     * Method used for computation.
     * @return static
     */
    public function compose(){
        // lets keep this easy for presentation purposes
        // compose expect to get integer value
        // and will multiply it by 2.
        
        $this->output = $this->args['value'] * 2;
        
        return $this;
    }
    
    /**
     * Args setter
     * @param array $args
     * @returns static
     */
    public function with(array $args = [])
    {
        $this->args = $args;
        return $this;
    }

    /**
     * @return mixed computed data
     */
    public function andReturn()
    {
        return $this->output;
    }
}
```

Example above represents basic implementation of Component.
All registered components are stacked and invoke one by one with given arguments.

## Create Composition

```php
<?php

use \Pawelzny\MetaClass\MetaCompose;
use \Pawelzny\MetaClass\Contracts\Composable;

class CustomComposition extends MetaCompose implements Composable
{
    /**
     * Custom component registry. Components are stacked 
     * as fully qualified class name with namespace.
     * It may be plain string "\Nested\Namespace\CustomComponent",
     * but better option is to use magic constant. 
     * Whenever you change Component name, compiler throw exception.
     * 
     * @var array $components
     */
    protected $components = [CustomComponent::class];
    
    /**
     * In this example, CustomComponent expected "value" argument.
     * 
     * @var array $args
     */
    protected $args = ['value' => 23];
}
```

Example above represents implementation of custom meta composition class.
All needed is inherit from MetaCompose class, and could be override if needed.

One of inherited method is `compose()` method because interface enforce it.
Compose invoke every component, passes args and gets it's computed value.
Then this value is stored in meta attribute under namespace which is snake_case component's name.
In this example it's "custom_component" namespace. We will get there for a second.

## Use Custom Composition inside Model

So we have component and compose classes. Now we need to declare to use it inside model.

```php
<?php

class User
{
    use \Pawelzny\MetaClass\MetaClass;
    
    /**
     * MetaClass checks if this $meta_class attribute exists.
     * If it is, then creates Meta object from it instead of default MetaCompose class.
     * Because CustomComposition class has components and args, all will be invoke one by one
     * and result of components computation will be stored inside meta object.
     * 
     * @var \Pawelzny\MetaClass\Contracts\Composable $meta_class
     */
    protected $meta_class = CustomComposition::class;
    
    // rest of user class
}

$user = new User;
assert($user->meta()->custom_component === 46); // 23 as input argument multiply by 2
```

# TODO

**Order by priority**

- [ ] Component abstraction
- [ ] Exceptions clean up
- [ ] Tests clean up, refactor and more cases
- [ ] Working example code 
- [ ] Contribution guide
- [ ] Changelog
