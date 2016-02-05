<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2016 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base;

/**
 * Class Traverser
 *
 * Array callback traverser.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Traverser
{
    // region: Properties

    /**
     * @var callable $itemCallback The Traverser instance item callback to run on arrays.
     */
    protected $itemCallback = null;

    /**
     * @var callable $resultCallback The Traverser instance result callback to run on traversed arrays.
     */
    protected $resultCallback = null;

    // endregion

    // region: Constructors

    /**
     * Default constructor
     *
     * @param callable $itemCallback   The item callback to operate into every item.
     * @param callable $resultCallback The result callback to operate into the result array.
     */
    public function __construct(callable $itemCallback = null, callable $resultCallback = null)
    {
        $this->itemCallback = $itemCallback;
        $this->resultCallback = $resultCallback;
    }

    // endregion

    // region: Get & Set

    /**
     * Sets the item callback.
     *
     * @param callable $itemCallback The new item callback to use.
     */
    public function setItemCallback(callable $itemCallback = null)
    {
        $this->itemCallback = $itemCallback;
    }

    /**
     * Gets the instance's item callback.
     *
     * @return callable Returns the instance's item callback.
     */
    public function getItemCallback()
    {
        return $this->itemCallback;
    }

    /**
     * Sets the result callback.
     *
     * @param callable $resultCallback The new result callback to use.
     */
    public function setResultCallback(callable $resultCallback = null)
    {
        $this->resultCallback = $resultCallback;
    }

    /**
     * Gets the instance's result callback.
     *
     * @return callable Returns the instance's result callback.
     */
    public function getResultCallback()
    {
        return $this->resultCallback;
    }

    // endregion

    // region: Status Testing

    /**
     * Checks if the item callback has been set.
     *
     * @return bool Returns true if the item callback has been set, false otherwise.
     */
    public function isReady()
    {
        return ($this->itemCallback !== null);
    }

    /**
     * Checks if a result callback has been set.
     *
     * @return bool Returns true if a result callback has been set, false otherwise.
     */
    public function hasResultCallback()
    {
        return ($this->resultCallback !== null);
    }

    // endregion

    // region: Execution

    /**
     * Runs the given array through the Traverser's callbacks.
     *
     * @param array $arr The array to traverse.
     *
     * @return array Returns the resulting array.
     */
    final public function traverse(array &$arr)
    {
        if (!$this->isReady()) {
            throw new \RuntimeException("The traverser is not ready, no valid item callback has been set.");
        }

        return static::run($arr, $this->itemCallback, $this->resultCallback);
    }

    /**
     * Runs the traverser across the given array and executes the item callback into every item of the array.
     *
     * The traverser also has a result callback to allow for 'macro' result processing.
     *
     * @param array    $arr            The array to traverse.
     * @param callable $itemCallback   The item callback to operate into every item.
     *                                 Callback signature used:
     *                                 - array function($value, $key, $arr) { }
     * @param callable $resultCallback The result callback to operate into the result array.
     *                                 Callback signature used:
     *                                 - mixed function($resultArray, $originalArray) { }
     *
     * @return array Returns the resulting array.
     */
    public static function run(array &$arr, callable $itemCallback, callable $resultCallback = null)
    {
        $result = [];
        foreach ($arr as $key => &$value) {
            // Run the callback and store the result in a variable so that we allow the key to be modified by the
            // callback. Also pass the original array if one needs to unset variables from the original array.
            $r = $itemCallback($value, $key, $arr);

            // Store the item callback's result with the (new) key.
            $result[$key] = $r;
        }

        if (!is_null($resultCallback)) {
            // Allow for the original array to be modified with the result array.
            return $resultCallback($result, $arr);
        }

        return $result;
    }

    // endregion
}
