<?php
/**
 * Meta Class connector.
 *
 * @package Pawelzny\MetaClass
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\Support\Predication;

/**
 * Class MetaClass
 *
 * @package Pawelzny\MetaClass
 */
trait MetaClass
{
    /**
     * Declaration of default meta class.
     * Will be used only if model does not declare meta_class property.
     *
     * @var string $_default_meta_class
     */
    protected $_default_meta_class = MetaCompose::class;

    /**
     * Cached MetaClass object
     * ensures single instance of MetaClass per Model.
     *
     * @var \Pawelzny\MetaClass\Contracts\Composable $_meta_class
     */
    private $_meta_class;

    /**
     * MetaClass interface exposes meta object instance.
     *
     * @api
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function meta()
    {
        if ($this->_meta_class === null) {
            $this->_meta_class = $this->_metaFactory();

            if (Predication\hasInterface($this->_meta_class, Composable::class)) {
                $this->_meta_class->compose();
            }
            $this->metaInit();
        }

        return $this->_meta_class;
    }

    /**
     * Initialize Meta methods and attributes.
     * This method is called only once after Meta class construction.
     * Allow to declare common attributes and methods every time on booting.
     *
     * @api
     * @return void
     */
    protected function metaInit()
    {
    }

    /**
     * Simple factory which initiate object from existing protected meta_class property.
     * If model does not declare meta_class, then factory will build default meta class
     * instance.
     *
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    private function _metaFactory()
    {
        return property_exists($this, 'meta_class') && $this->meta_class !== null
            ? new $this->meta_class($this)
            : new $this->_default_meta_class($this);
    }
}
