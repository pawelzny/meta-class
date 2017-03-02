<?php
/**
 * MetaComponent.
 *
 * @package Pawelzny\MetaClass
 * @author  Paweł Zadrożny <pawel.zny@gmail.com>
 * @license ISC https://opensource.org/licenses/ISC
 */
namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composition;
use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\ComposeException;
use Pawelzny\Support\Mutation;
use Pawelzny\Support\Predication;

/**
 * MetaCompose is meant to be extend by custom Meta Composable classes.
 *
 * In fact MetaCompose is fully functional class with all needed setters and getters.
 * But if one prefer more declarative programming style, MetaCompose is
 * perfect for further extending.
 *
 * @package Pawelzny\MetaClass
 */
class MetaCompose extends MetaModel implements MetaExpansible, Composable
{
    /**
     * Registry with Components classes used by MetaCompose class
     * All Components must implement interface: \Pawelzny\MetaClass\Contracts\Composable
     *
     * @var array $components Components registry
     */
    protected $components = [];

    /**
     * Registry with arguments for components.
     *
     * @var array $args Arguments registry.
     */
    protected $args = [];

    /**
     * MetaCompose constructor.
     *
     * @param mixed $model Any object.
     */
    public function __construct($model = null)
    {
        parent::__construct($model);
        $this->with(['model' => $this->model]);
    }

    /**
     * Compose meta features from declared $components.
     *
     * @api
     * @return static
     * @throws ComposeException
     */
    public function compose()
    {
        foreach ($this->getComponents() as $component => $class) {
            /**
             * New instance of Component class.
             *
             * @var Composition $obj Component instance.
             */
            $obj = new $class;

            if (! Predication\hasInterface($obj, Composition::class)) {
                throw new ComposeException(get_class($obj));
            }

            $composed_data = $obj->with($this->getArgs())->compose()->andReturn();
            $this->setAttribute(Mutation\getClassName($class, $component), $composed_data);
        }

        return $this;
    }

    /**
     * Registers component's arguments. This method is needed only for expressions.
     * If computed value is needed use this method to insert more components_input.
     * $component_inputs will be passed to every registered component.
     * WARNING! There is no validation, no sanitizing and no collision control.
     *
     * By default MetaCompose uses `model` key for $model instance.
     *
     * @param  array $args Arguments
     *
     * @api
     * @return static
     */
    public function with(array $args = [])
    {
        $this->args = array_merge($this->args, $args);

        return $this;
    }

    /**
     * Returns component's arguments.
     * If key is specified returns only single value instead of whole array.
     *
     * @param  string $key specific argument
     *
     * @api
     * @return mixed
     */
    public function getArgs($key = null)
    {
        if ($key) {
            return array_key_exists($key, $this->args)
                ? $this->args[$key]
                : null;
        }

        return $this->args;
    }

    /**
     * Registers components used by MetaCompose.
     * Takes one or array of fully qualified class name with namespace.
     *
     * Component will be registered under given class name converted to snake_case.
     * Components could be registered under aliases by passing in associative array.
     *
     * @param  array|string $components Components to register.
     *
     * @api
     * @return static
     */
    public function setComponents($components)
    {
        foreach ((array) $components as $name => $component) {
            $this->components[Mutation\getClassName($component, $name)] = $component;
        }

        return $this;
    }

    /**
     * Gets all registered components.
     *
     * @api
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }
}
