<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;

class MetaModel extends Meta implements MetaExpansible
{
    /**
     * Model instance
     * @var object
     */
    protected $model = null;

    /**
     * Meta constructor.
     * @param object $model
     */
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    /**
     * Sets model instance once
     * @param object $model
     * @return \Pawelzny\MetaClass\Contracts\MetaExpansible
     */
    public function setModel($model)
    {
        if ($this->model !== null) {
            $this->model = $model;
        }

        return $this;
    }
}
