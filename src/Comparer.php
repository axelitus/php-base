<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base;

use Closure;

/**
 * Class Comparer
 *
 * Simple and flexible base comparer from which new comparers should be derived.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
abstract class Comparer
{
    // region: Properties

    /**
     * @var \Closure The callback to use for comparison.
     */
    protected $callback = null;

    /**
     * @var \axelitus\Base\Arr The comparer options to be used while comparing
     */
    protected $options = null;

    // endregion

    // region: Constructor

    /**
     * Default constructor
     *
     * @param Closure $callback The callback to use for comparison.
     *                          Callback signature used:
     *                          - int function($item1, $item2, array $options) { }
     * @param array   $options  The options of the callback.
     */
    public function __construct(Closure $callback = null, array $options = [])
    {
        if ($callback !== null) {
            $this->setCallback($callback);
        }
        $this->options = new Arr($options);
    }

    // endregion

    // region: Get & Set

    /**
     * Sets the callback and binds it to the Comparer instance.
     *
     * @param Closure $callback The new callback to use.
     */
    public function setCallback(Closure $callback = null)
    {
        $this->callback = ($callback === null) ? null : Closure::bind($callback, $this, get_called_class());
    }

    /**
     * Gets the instance's callback.
     *
     * @return Closure Returns the instance's callback.
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Gets a comparer option.
     *
     * @param int|string|array $key     The option(s) to get.
     * @param mixed            $default The default value to get if the given key does not exist
     *
     * @return mixed The value of the option or the default value.
     */
    public function getOption($key, $default = null)
    {
        return $this->options->get($key, $default);
    }

    /**
     * Sets a comparer option (or multiple options).
     *
     * @param int|string|array $key   The key of the item to set (or associative array with key => value pairs).
     * @param null|mixed       $value The value to set.
     */
    public function setOption($key, $value = null)
    {
        $this->options[$key] = $value;
    }

    /**
     * Deletes a value from the options.
     *
     * @param int|string|array $key The key of the option(s) to delete.
     */
    public function deleteOption($key)
    {
        $this->options->delete($key);
    }

    // endregion

    // region: Status Testing

    /**
     * Checks if the callback has been set.
     *
     * @return bool Returns true if the callback has been set, false otherwise.
     */
    public function isReady()
    {
        return ($this->callback !== null);
    }

    // endregion

    // region: Comparison

    /**
     * Compares two items.
     *
     * @param mixed $item1 The left operand.
     * @param mixed $item2 The right operand.
     *
     * @throws \RuntimeException
     * @return int Return <0 if $item1<$item2; 0if $item1=$item2; >1 if $item1>$item2
     */
    final public function compare($item1, $item2)
    {
        if (!$this->isReady()) {
            throw new \RuntimeException("The comparer is not ready, no valid callback has been set.");
        }

        return call_user_func_array($this->callback, [$item1, $item2, $this->options]);
    }

    // endregion
}
