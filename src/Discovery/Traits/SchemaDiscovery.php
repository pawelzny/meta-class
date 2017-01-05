<?php

namespace Pawelzny\Discovery\Traits;

use Pawelzny\Discovery\Models\Schema;
use Pawelzny\Discovery\Services\UnknownConnection;

trait SchemaDiscovery
{
    protected $meta_schema = Schema::class;

    public function discover()
    {
        if (gettype($this->meta_schema) != 'object') {
            $conn = ! is_null($this->meta_connection) ? new $this->meta_connection() : new UnknownConnection();
            $this->meta_schema = new $this->meta_schema($this, $conn);
        }

        return $this->meta_schema;
    }
}
