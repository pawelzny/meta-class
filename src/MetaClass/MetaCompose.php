<?php

namespace Pawelzny\MetaClass;

use Pawelzny\MetaClass\Contracts\Composable;
use Pawelzny\MetaClass\Contracts\MetaExpansible;
use Pawelzny\MetaClass\Exceptions\ComposableException;

/**
 * Class MetaCompose.
 * This class is meant to be extend by custom Meta Composable classes.
 *
 * In fact MetaCompose is fully functional class with all needed setters and getters.
 * But if one prefer more declarative programming style, MetaCompose is
 * perfect for further extending.
 *
 * @example
 *
 * // Imperative way
 *
 * $user = new User;
 * $meta = new MetaCompose($user); // create meta object for $user
 * $meta->setComponents([CustomComponent::class, BestComponent::class])
 *      ->with(['some_data' => 'abc'])
 *      ->compose(); // compose meta data for $some_object
 * $meta->extra_attribute = 'I am cool';
 *
 * echo $meta->custom_component;
 * echo $meta->best_component;
 * echo $meta->extra_attribute;
 *
 * // Declarative way
 *
 * // First step: build your custom MetaCompose class
 * class CustomCompose extends MetaCompose implements Composable
 * {
 *      protected $components = [CustomComponent::class, BestComponent::class];
 *      protected $compose_with = ['some_data' => 'abc'];
 * }
 *
 * class User
 * {
 *      // Second step: use MetaClass trait to autoload and initialize MetaCompose class.
 *      use \Pawelzny\MetaClass\MetaClass;
 *
 *      // Third step: declare that you want to use
 *      // CustomCompose::class instead of default MetaCompose::class
 *      protected $meta_class = CustomCompose::class;
 *
 *      // Optional step: Initialize meta attributes and function.
 *      // This method is called only once on Meta object construction.
 *      protected function metaInit()
 *      {
 *          $this->meta()->extra_attribute = 'I am cool';
 *      }
 * }
 *
 * $user = new User;
 * $meta = $user->meta(); // Meta is fully initialized with composed components and.
 * echo $meta->custom_component;
 * echo $meta->best_component;
 * echo $meta->extra_attribute;
 *
 * @package Pawelzny\MetaClass
 */
class MetaCompose extends MetaModel implements MetaExpansible, Composable
{
    /**
     * Associative array of Composable extensions.
     * which are booted on MetaCompose initialization.
     * All components must implement interface: \Pawelzny\MetaClass\Contracts\Composable
     *
     * @var array $components
     */
    protected $components = [];

    /**
     * Predeclared array with standard input for components.
     *
     * @var array $args
     */
    protected $args = [];

    /**
     * MetaCompose constructor.
     *
     * @param null $model
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
     * @return Composable
     * @throws ComposableException
     */
    public function compose()
    {
        foreach ($this->getComponents() as $component => $class) {
            /**
             * @var Composable $obj
             */
            $obj = new $class;

            if (! $this->isComposable($obj)) {
                throw new ComposableException($obj);
            }

            $composed_data = $obj->with($this->getArgs())->compose()->andReturn();
            $this->setAttribute($this->registerAs($class, $component), $composed_data);
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
     * @api
     * @param array $args Arguments
     * @return static
     */
    public function with(array $args = [])
    {
        $this->args = array_merge($this->args, $args);

        return $this;
    }

    /**
     * Returns compose computed value.
     * This is dummy interface implementation.
     * There is no usage in MetaCompose context.
     *
     * @return mixed
     */
    public function andReturn()
    {
        return $this;
    }

    /**
     * Returns component's arguments.
     * If key is specified returns only single value instead of whole array.
     *
     * @api
     * @param null $key specific argument
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
     * @api
     * @example
     *
     * $meta = new MetaCompose;
     *
     * // register 'custom_component'.
     * $meta->setComponents(CustomComponent::class);
     *
     * // register 'best_component' and 'super_component'.
     * $meta->setComponents([BestComponent::class, SuperComponent::class]);
     *
     * // register 'best' and 'the_best' components
     * $meta->setComponents([
     *      'best' => \Best\Component::class,
     *      'the_best' => \TheBest\Component::class
     * ]);
     *
     * @param array|string $components
     * @return static
     */
    public function setComponents($components)
    {
        foreach((array) $components as $name => $component) {
            $this->components[$this->registerAs($component, $name)] = $component;
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

    /**
     * Predicate if MetaClass is schema discoverable.
     *
     * @param $class
     * @return bool
     */
    protected function isComposable($class)
    {
        return $class !== null && in_array(Composable::class, class_implements($class));
    }

    /**
     * Sanitize Component name.
     * If name is index of array or null then return snake_case class name.
     *
     * @param string $component
     * @param string|int $name
     * @param string $prefix
     * @return string
     */
    protected function registerAs($component, $name = null, $prefix = null)
    {
        if (is_int($name) || $name === null) {
            $_component = new \ReflectionClass($component);
            $name = to_snake_case($_component->getShortName());
        }

        if ($prefix) {
            $name = $prefix . $name;
        }

        return $name;
    }
}
