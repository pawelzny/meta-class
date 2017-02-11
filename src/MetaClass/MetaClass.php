<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;

trait MetaClass
{
    /**
     * Cached MetaClass object
     * @var null|\Pawelzny\MetaClass\Contracts\Composable
     */
    private $_meta_class = null;

    /**
     * Returns instance of Meta class
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function meta()
    {
        if ($this->_meta_class === null) {
            $this->_meta_class = $this->getMetaClass();

            if ($this->hasInterface(Composable::class)) {
                $this->_meta_class->compose();
            }
            $this->metaInit();
        }

        return $this->_meta_class;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     */
    protected function metaInit()
    {
    }

    /**
     * Create MetaClass object from existing meta_class property
     * or default \Pawelzny\MetaClass\Model\Meta class if no custom meta_class exists
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    private function getMetaClass()
    {
        return property_exists($this, 'meta_class') && isset($this->meta_class)
            ? new $this->meta_class($this)
            : new MetaCompose($this);
    }

    /**
     * Predicates if Meta object implements given interface.
     * @param string $interface
     * @return bool
     */
    private function hasInterface($interface)
    {
        return in_array($interface, class_implements($this->_meta_class));
    }
}
