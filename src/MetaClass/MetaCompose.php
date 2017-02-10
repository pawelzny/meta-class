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
 * But if one prefer more declarative programming style MetaCompose it's
 * perfect for further extending.
 *
 * @example
 *
 * // Imperative usage
 * $some_obj = new SomeClass;
 *
 * $meta = new MetaCompose($some_obj); // create meta object for $some_object
 * $meta->setComponents([CustomComponent::class, BestComponent::class])
 *      ->with(['some_data' => 'abc'])
 *      ->compose(); // compose meta data for $some_object
 *
 * // Declarative usage
 * // First build your custom MetaCompose class
 * class CustomCompose extends MetaCompose implements Composable
 * {
 *      protected $components = [CustomComponent::class, BestComponent::class];
 *      protected $compose_with = ['some_data' => 'abc'];
 * }
 *
 * class User
 * {
 *      // second use MetaClass trait to autoload MetaCompose class.
 *      use \Pawelzny\MetaClass\MetaClass;
 *
 *      // declare that you want to use your CustomCompose::class instead of default MetaCompose::class
 *      protected $meta_class = CustomCompose::class;
 * }
 *
 * $user = new User;
 * $meta = $user->meta(); // CustomCompose::class is fully initialized with composed components.
 * echo $meta->customcomponent;
 * echo $meta->bestcomponent;
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
     * @var array
     */
    protected $components = [];

    /**
     * Predeclared array with standard input for components.
     *
     * @var array
     */
    protected $compose_with = [];

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

            $this->setAttribute($component, $obj->with($this->getComposeWith())->compose()->andReturn());
        }

        return $this;
    }

    /**
     * Registers component's inputs. This method is needed only for expressions.
     * If computed value is needed use this method to insert more components_input.
     * $component_inputs will be passed to every registered component.
     * WARNING! There is no validation, no sanitizing and no collision control.
     *
     * By default MetaCompose uses `model` key for $model instance.
     *
     * @api
     * @param array $items
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function with(array $items = [])
    {
        $this->compose_with = array_merge($this->compose_with, $items);

        return $this;
    }

    /**
     * Returns compose computed value.
     * This is dummy interface implementation.
     * There is no usage in MetaCompose context.
     *
     * @return \Pawelzny\MetaClass\MetaCompose
     */
    public function andReturn()
    {
        return $this;
    }

    /**
     * Returns component's compose_with data inputs.
     *
     * @api
     * @return array
     */
    public function getComposeWith()
    {
        return $this->compose_with;
    }

    /**
     * Registers component used by MetaCompose.
     * This must not be component object but fully qualified class names with namespaces.
     * Second parameter is optional.
     * If $name is not specified, component will be registered under lower case class name
     * without namespace.
     *
     * @api
     * @example
     *
     * MetaCompose::setComponent(CustomComponent::class, "custom");
     * MetaCompose::setComponent(BestComponent::class);
     *
     * @param string $name
     * @param string $component
     * @return $this
     */
    public function setComponent($component, $name = null)
    {
        $this->components[$this->registerAs($component, $name)] = $component;

        return $this;
    }

    /**
     * Registers multiple components used by MetaCompose.
     * These must not be components objects but fully qualified class names with namespaces.
     * Components array may be associative and every component can get alias name.
     * When $components variable is index based array, every component will be
     * registered using it's lower case class name.
     *
     * @api
     * @example
     *
     * MetaCompose::setComponents([
     *  CustomComponent::class,
     *  'best' => \Best\Component::class,
     *  'the_best' => \TheBest\Component::class
     * ]);
     *
     * @param array $components
     * @return \Pawelzny\MetaClass\Contracts\Composable
     */
    public function setComponents(array $components = [])
    {
        foreach($components as $name => $component) {
            $this->setComponent(new $component, $name);
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
    private function isComposable($class)
    {
        return $class !== null && in_array('Composable', class_implements($class));
    }

    /**
     * Sanitize Component name.
     * If name is index of array or null then return lower case class name.
     *
     * @param string $component
     * @param null $name
     * @return string
     */
    private function registerAs($component, $name = null)
    {
        if (is_int($name) || $name === null) {
            $_component = new \ReflectionClass($component);
            $name = strtolower($_component->getShortName());
        }

        return $name;
    }
}
