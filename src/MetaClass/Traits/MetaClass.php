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
     * Returns instance of Meta class
     * @return Meta
     */
    public function meta()
    {
        // Create new Meta class instance on first call.
        if (gettype($this->meta_class) != 'object') {
            $this->meta_class = new $this->meta_class($this);
            $this->metaInit();
        }
        return $this->meta_class;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     */
    protected function metaInit()
    {
    }
}
