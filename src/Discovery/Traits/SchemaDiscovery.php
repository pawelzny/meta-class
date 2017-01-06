<?php

namespace Pawelzny\Discovery\Traits;

use Pawelzny\Discovery\Models\Schema;
use Pawelzny\Discovery\Services\UnknownConnection;
use Pawelzny\Monads\Maybe;

trait SchemaDiscovery
{
    protected $meta_schema = Schema::class;

    public function discover()
    {
        if (gettype($this->meta_schema) != 'object') {
            $conn = ! is_null($this->meta_connection) ? $this->meta_connection : UnknownConnection::class;
            (new Maybe(new $conn()))->then(function ($connection) {
                $this->meta_schema = new $this->meta_schema($this, $connection);
            });
        }

        return $this->meta_schema;
    }
}
