<?php

namespace Pawelzny\MetaClass\Models;

use Pawelzny\Discovery\Discovery;
use Pawelzny\MetaClass\Exceptions\ForbiddenException;
use Pawelzny\MetaClass\Exceptions\MetaAttributeException;
use Pawelzny\MetaClass\Exceptions\MetaMethodException;

class Meta
{
    protected $class;
    protected $methods = [];
    protected $attributes = [];
    protected $forbidden = ['methods', 'attributes', 'class'];

    /**
     * Meta constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
        $this->setModelFields();

        if ($this->class->form) {
            $this->form = \App::make($this->class->form, [$this->class->getFillable(), $this->fields]);
        }
    }

    /**
     * TODO: unhardcode to be available outside of Laravel
     */
    private function setModelFields()
    {
        $fields = Discovery::Schema()->listTableColumns($this->class->getTable());

        $guarded = $this->class->getGuarded();
        if (count($guarded) > 1 && ! in_array('*')) {
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

        $this->fields = array_map(function ($field) {
            return $field->toArray();
        }, array_filter($fields, $filter));
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name)
    {
        return array_key_exists($name, $this->methods);
    }

    /**
     * @param {string} $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    public function __call($method, $arguments)
    {
        if (! $this->hasMethod($method)) {
            throw new MetaMethodException($method);
        }

        return call_user_func_array($this->methods[$method], $arguments);
    }

    public function __set($property, $value)
    {
        if (in_array($property, $this->forbidden)) {
            throw new ForbiddenException($property);
        }

        if ($value instanceof \Closure) {
            $this->methods[$property] = $value;
        } else {
            $this->attributes[$property] = $value;
        }
    }

    public function __get($attribute)
    {
        if (! $this->hasAttribute($attribute)) {
            throw new MetaAttributeException($attribute);
        }

        return $this->attributes[$attribute];
    }
}
