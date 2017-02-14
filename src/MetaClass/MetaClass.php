<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\Support;

/**
 * Class MetaClass
 *
 * @package Pawelzny\MetaClass
 */
trait MetaClass
{
    /**
     * Cached MetaClass object
     *
     * @var null|\Pawelzny\MetaClass\Contracts\Composable $_meta_class
     */
    private $_meta_class = null;

    /**
     * Returns instance of Meta class
     *
     * @api
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function meta()
    {
        if ($this->_meta_class === null) {
            $this->_meta_class = $this->metaFactory();

            if (Support\hasInterface($this->_meta_class, Composable::class)) {
                $this->_meta_class->compose();
            }
            $this->metaInit();
        }

        return $this->_meta_class;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     *
     * @api
     * @return void
     */
    protected function metaInit()
    {
    }

    /**
     * Create MetaClass object from existing meta_class property
     * or default \Pawelzny\MetaClass\Model\Meta class if no custom meta_class exists
     *
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    private function metaFactory()
    {
        return property_exists($this, 'meta_class') && isset($this->meta_class)
            ? new $this->meta_class($this)
            : new MetaCompose($this);
    }
}
