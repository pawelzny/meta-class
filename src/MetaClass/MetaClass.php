<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Model\Meta;

trait MetaClass
{
    private static $meta_class = null;

    /**
     * Returns instance of Meta class
     * @return Meta
     */
    public function meta()
    {
        if (static::$meta_class === null) {
            static::$meta_class = new Meta($this);
            $this->metaInit();
        }

        return static::$meta_class;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     */
    protected function metaInit()
    {
    }
}
