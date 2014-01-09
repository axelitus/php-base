<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.0
 */

namespace axelitus\Base;

/**
 * Class DotArr
 *
 * Dot-Notated Array operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class DotArr
{
    //region Value Testing

    /**
     * Tests if the given value is a dot-notated accessible array.
     *
     * This function tests if none of the keys contains a dot.
     *
     * @param array $arr The array to test.
     *
     * @return bool Returns true if the array is dot-notated accessible, false otherwise.
     */
    public static function is(array $arr)
    {
        $isdot = true;
        foreach ($arr as $key => $value) {
            $isdot = ($isdot && !Str::contains($key, '.'));
            if (is_array($value)) {
                $isdot = ($isdot && static::is($value));
            }
        }

        return $isdot;
    }

    //endregion

    //region Get & Set

    /**
     * Gets a value from a dot-notated array.
     *
     * @param array            $arr     The array to get the value from.
     * @param int|string|array $key     The key of the item's value to get or an array of keys.
     * @param mixed            $default A default value to return if the item is not found.
     *
     * @return mixed The value of the item if found, the default value otherwise.
     * @throws \InvalidArgumentException
     */
    public static function get(array $arr, $key, $default = null)
    {
        if (is_array($key)) {
            return static::getMultiple($arr, $key, $default);
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        foreach (explode('.', $key) as $keySeg) {
            if (!is_array($arr) || !array_key_exists($keySeg, $arr)) {
                return $default;
            }

            $arr = $arr[$keySeg];
        }

        return $arr;
    }

    /**
     * Gets multiple values from a dot-notated array.
     *
     * @internal
     *
     * @param array $arr     The array to get the values from.
     * @param array $keys    The keys to the items to get the values from.
     * @param mixed $default A default value to return if the item is not found.
     *
     * @return array The values of the found items or the default values if not found.
     */
    private static function getMultiple(array $arr, array $keys, $default = null)
    {
        $return = [];
        foreach ($keys as $key) {
            $return[$key] = static::get($arr, $key, $default);
        }

        return $return;
    }

    /**
     * Sets a value to a dot-notated array.
     *
     * @param array            $arr   The array to set the value to.
     * @param int|string|array $key   The key of the item to be set or an array of key=>value pairs.
     * @param mixed            $value The value to be set to the item.
     *
     * @throws \InvalidArgumentException
     */
    public static function set(array &$arr, $key, $value = null)
    {
        if (is_array($key)) {
            static::setMultiple($arr, $key);
            return;
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($arr[$key]) || !is_array($arr[$key])) {
                $arr[$key] = [];
            }
            $arr =& $arr[$key];
        }

        $arr[array_shift($keys)] = $value;
    }

    /**
     * Sets multiple values to a dot-notated array.
     *
     * @internal
     *
     * @param array $arr     The array to set the values to.
     * @param array $keyvals The key=>value associative array to set the item values.
     */
    private static function setMultiple(array &$arr, array $keyvals)
    {
        foreach ($keyvals as $key => $value) {
            static::set($arr, $key, $value);
        }
    }

    /**
     * Deletes an item from a dot-notated array.
     *
     * @param array            $arr The dot-notated array.
     * @param int|string|array $key The key of the item to delete or array of keys.
     *
     * @return bool|array Returns true if the item was found and deleted, false otherwise (or an array of results).
     * @throws \InvalidArgumentException
     */
    public static function delete(array &$arr, $key)
    {
        if (is_array($key)) {
            return static::deleteMultiple($arr, $key);
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        // TODO: optimize this chunk of code
        $tmp =& $arr;
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!is_array($tmp[$key])) {
                return false;
            }

            $tmp =& $tmp[$key];
        }

        $key = array_shift($keys);
        if (array_key_exists($key, $tmp)) {
            unset($tmp[$key]);

            return true;
        }

        return false;
    }

    /**
     * Deletes multiple items from a dot-notated array.
     *
     * @internal
     *
     * @param array $arr  The array to delete the items from.
     * @param array $keys The keys of the items to delete.
     *
     * @return array Returns an array of results.
     */
    private static function deleteMultiple(array &$arr, array $keys)
    {
        $return = [];
        foreach ($keys as $key) {
            $return[$key] = static::delete($arr, $key);
        }

        return $return;
    }

    //endregion

    //region Matches

    /**
     * Verifies if an item with the given key exists in a dot-notated array or not.
     *
     * @param array            $arr The dot-notated array.
     * @param int|string|array $key The key of the item to check for or an array of keys.
     *
     * @return bool|array Returns true if the item exists, false otherwise (or an array of results).
     * @throws \InvalidArgumentException
     */
    public static function keyExists(array $arr, $key)
    {
        if (is_array($key)) {
            return static::keyExistsMultiple($arr, $key);
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        if (array_key_exists($key, $arr)) {
            return true;
        }

        foreach (explode('.', $key) as $key_seg) {
            if (!is_array($arr) || !array_key_exists($key_seg, $arr)) {
                return false;
            }

            $arr = $arr[$key_seg];
        }

        return true;
    }

    /**
     * Verifies if multiple keys exists in a dot-notated array or not.
     *
     * @param array $arr  The dot-notated array.
     * @param array $keys The keys to verify.
     *
     * @return array The array of results.
     */
    private static function keyExistsMultiple(array $arr, array $keys)
    {
        $return = [];
        foreach ($keys as $key) {
            $return[$key] = static::keyExists($arr, $key);
        }

        return $return;
    }

    /**
     * Gets full and partial matches to the given key.
     *
     * The function matches each key sub level to a partial match.
     *
     * @param array            $arr The array to match the key to.
     * @param int|string|array $key The key to be matched or an array of keys.
     *
     * @return array The array of full and partial matches.
     * @throws \InvalidArgumentException
     */
    public static function keyMatches(array $arr, $key)
    {
        if (is_array($key)) {
            return static::keyMatchesMultiple($arr, $key);
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        $match = '';
        $return = [];
        foreach (explode('.', $key) as $k) {
            if (!is_array($arr) || !array_key_exists($k, $arr)) {
                return $return;
            }

            $match .= (($match != '') ? '.' : '') . $k;
            $return[] = $match;
            $arr =& $arr[$k];
        }

        return $return;
    }

    /**
     * Gets full and partial matches to multiple keys.
     *
     * @param array $arr  The array to match the keys to.
     * @param array $keys The keys to be matched.
     *
     * @return array The array of ful and partial matches of the given keys.
     */
    private static function keyMatchesMultiple(array $arr, array $keys)
    {
        $return = [];
        foreach ($keys as $key) {
            $return[$key] = static::keyMatches($arr, $key);
        }

        return $return;
    }

    //endregion

    //region Convert

    /**
     * Converts an array to a dot-notated array.
     *
     * Be aware that some values may be lost in this conversion if a partial key match is found
     * twice or more. The last found element of a partial key match is the one that takes precedence.
     *
     * @param array $arr The array to convert.
     *
     * @return array The converted array.
     */
    public static function convert(array $arr)
    {
        $converted = [];
        foreach ($arr as $key => $value) {
            $keys = explode('.', $key);
            $tmp =& $converted;
            foreach ($keys as $k) {
                if (!array_key_exists($k, $tmp) || !is_array($tmp[$k])) {
                    $tmp[$k] = [];
                }

                $tmp =& $tmp[$k];
            }

            $tmp = is_array($value) ? static::convert($value) : $value;
        }

        return $converted;
    }

    //endregion
}
