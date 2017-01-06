<?php

namespace Pawelzny\Discovery\Contracts;

interface SchemaDiscoverable
{
    /**
     * Returns array of model schema columns.
     * If there is no connection to database or
     * can't sniff schema, returns null.
     * @return array|null
     */
    public function getModelFields();
}
