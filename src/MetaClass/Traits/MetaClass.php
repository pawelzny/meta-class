<?php

namespace Pawelzny\MetaClass\Traits;

use Pawelzny\MetaClass\Models\Meta;

trait MetaClass
{
    /**
     * Meta Class
     * @var Meta Class namespace and name
     */
    protected $meta_class = Meta::class;

    /**
     * Holds Meta class instance.
     * @var Meta
     */
    private static $_meta_instance = null;

    /**
     * Returns instance of Meta class
     * @return Meta
     */
    public function meta()
    {
        // Create new Meta class instance on first call.
        if (static::$_meta_instance === null) {
            static::$_meta_instance = new $this->meta_class($this);
            $this->metaInit();
        }

        return static::$_meta_instance;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     */
    protected function metaInit()
    {
    }
}
