<?php

namespace Pawelzny\MetaClass\Model;

use Pawelzny\MetaClass\Contracts\MetaComposable;
use Pawelzny\MetaClass\Contracts\MetaExpansible;

class MetaCompose extends Meta implements MetaExpansible, MetaComposable
{
    /*
     * Schema discoverable components
     */
    protected $schema_discover = null;
    protected $schema_discover_connection = null;
    private $schema;

    /**
     * Compose meta features from declared components
     */
    public function compose()
    {
        $this->composeDiscoverSchema();
    }

    /**
     * Compose model's schema discoverable module
     */
    protected function composeDiscoverSchema()
    {
        if ($this->isSchemaDiscoverable()) {
            $this->schema = new $this->schema_discover($this->model, $this->schema_discover_connection);
            $this->setAttribute('schema', $this->schema->getModelSchema());
        }
    }

    /**
     * Predicate if MetaClass is schema discoverable
     * @return bool
     */
    private function isSchemaDiscoverable()
    {
        return $this->hasProperty('schema_discover') && $this->hasProperty('schema_discover_connection');
    }
}
