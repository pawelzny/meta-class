<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;

class MetaModel extends Meta implements MetaExpansible
{
    /**
     * Model instance
     *
     * @var object $model
     */
    protected $model = null;

    /**
     * Meta constructor.
     *
     * @param object $model
     */
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    /**
     * Sets model instance once
     *
     * @api
     * @param object $model
     * @return static
     */
    public function setModel($model)
    {
        if ($this->model === null) {
            $this->model = $model;
        }

        return $this;
    }
}
