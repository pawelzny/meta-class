<?php

namespace Pawelzny\Discovery\Traits;

use Pawelzny\Discovery\Models\Discovery;
use Pawelzny\Discovery\Services\Environment;

trait Discoverable
{
    protected $meta_environment = Environment::class;

    private static $_meta_discover = null;

    public function discover()
    {
        if (static::$_meta_discover === null) {
            static::$_meta_discover = new Discovery($this, $this->meta_environment);
            $this->metaDiscoverInit();
        }

        return static::$_meta_discover;
    }

    protected function metaDiscoverInit()
    {
    }
}
