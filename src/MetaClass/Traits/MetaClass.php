<?php

namespace Pawelzny\MetaClass\Traits;

use Pawelzny\MetaClass\Models\Meta;

trait MetaClass
{
    /**
     * Holds Meta class instance.
     * @var Meta
     */
    protected static $_meta = null;

    /**
     * Returns instance of Meta class
     * @return Meta
     */
    public function meta()
    {
        // Create new Meta class instance on first call.
        if (static::$_meta === null) {
            static::$_meta = new Meta($this);
            $this->initMeta();
        }

        return static::$_meta;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     */
    protected function initMeta()
    {
    }
}
