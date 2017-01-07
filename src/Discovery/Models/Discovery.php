<?php namespace Pawelzny\Discovery\Models;

abstract class Discovery
{
    /**
     * @var null|mixed
     */
    protected $model = null;

    /**
     * Discovery constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
