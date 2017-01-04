<?php

namespace Pawelzny\Discovery\Traits;

use Pawelzny\Discovery\Models\Discovery;
use Pawelzny\Discovery\Services\UnknownConnection;

trait Discoverable
{
    protected $meta_connection = UnknownConnection::class;

    private static $_meta_discover = null;

    public function discover()
    {
        if (static::$_meta_discover === null) {
            $connection = new $this->meta_connection();
            static::$_meta_discover = new Discovery($this, $connection);
            $this->metaDiscoverInit();
        }

        return static::$_meta_discover;
    }

    protected function metaDiscoverInit()
    {
    }
}
