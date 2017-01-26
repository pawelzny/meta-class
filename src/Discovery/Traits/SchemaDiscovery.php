<?php

namespace Pawelzny\Discovery\Traits;

use Pawelzny\Discovery\Connections\UnknownConnection;
use Pawelzny\Discovery\Contracts\Connectable;
use Pawelzny\Discovery\Models\Schema;
use Pawelzny\Monads\Maybe;

trait SchemaDiscovery
{
    /**
     * @var Connectable|string
     */
    protected $meta_schema = Schema::class;

    /**
     * @return Connectable|null
     */
    public function discover()
    {
        if (gettype($this->meta_schema) != 'object') {
            $conn = ! is_null($this->meta_connection) ? $this->meta_connection : UnknownConnection::class;

            $setMetaSchema = function ($connection) {
                return new $this->meta_schema($this, $connection);
            };
            $maybe = new Maybe(new $conn());
            $this->meta_schema = $maybe->then($maybe($setMetaSchema))->extract();
        }

        return $this->meta_schema;
    }
}
