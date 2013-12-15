<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.7.2
 */

namespace axelitus\Base;

/**
 * Class Traverser
 *
 * Array traverser.
 *
 * @package axelitus\Base
 */
class Traverser
{
    /**
     * Runs the traverser across the given array and executes the item callback into every item of the array.
     *
     * The traverser also has a result callback to allow for 'macro' result processing.
     *
     * @param array    $arr            The array to traverse.
     * @param callable $itemCallback   The item callback to operate into every item.
     * @param callable $resultCallback The result callback to operate into the result array.
     *
     * @return array
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
}