<?php
/**
 * MetaModel class implementation.
 * Allow to set model object used by meta object.
 *
 * @package Pawelzny\MetaClass
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://github.com/pawelzny/meta-class/blob/master/LICENSE.md
 */
namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\MetaExpansible;

/**
 * Class MetaModel
 *
 * @package Pawelzny\MetaClass
 */
class MetaModel extends Meta implements MetaExpansible
{
    /**
     * Model instance
     *
     * @var mixed $model
     */
    protected $model;

    /**
     * Meta constructor.
     *
     * @param mixed $model Any object.
     */
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    /**
     * Sets model instance once
     *
     * @param mixed $model Any object.
     *
     * @api
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
