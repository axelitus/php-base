<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.5
 */

namespace axelitus\Base;

/**
 * Class DotArr
 *
 * Dot-Notated Array operations.
 *
 * @package axelitus\Base
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
            $return = [];
            foreach ($key as $k) {
                $return[$k] = static::get($arr, $k, $default);
            }
            return $return;
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        }

        foreach (explode('.', $key) as $key_seg) {
            if (!is_array($arr) || !array_key_exists($key_seg, $arr)) {
                return $default;
            }

            $arr = $arr[$key_seg];
        }

        return $arr;
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
            foreach ($key as $k => $v) {
                static::set($arr, $k, $v);
            }
        } else {
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
    }

    public static function delete(array &$arr, $key)
    {
        if (is_array($key)) {
            $return = [];
            foreach ($key as $k) {
                $return[$k] = static::delete($arr, $k);
            }
            return $return;
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

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

    //endregion

    //region Matches

    public static function keyExists(array $arr, $key)
    {
        if (is_array($key)) {
            $return = [];
            foreach ($key as $k) {
                $return[$k] = static::keyExists($arr, $k);
            }
            return $return;
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
     * Gets all full and partial matches to the given key.
     *
     * The function matches each key sub level to a partial match.
     *
     * @param array            $arr The array to match the key to.
     * @param int|string|array $key The key to be matched or an array of keys.
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function keyMatches(array $arr, $key)
    {
        if (is_array($key)) {
            $return = [];
            foreach ($key as $k) {
                $return[$k] = static::keyMatches($arr, $k);
            }
            return $return;
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or an array of them).");
        }

        if (array_key_exists($key, $arr)) {
            return [$key];
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

            if (is_array($value)) {
                $tmp = static::convert($value);
            } else {
                $tmp = $value;
            }
        }

        return $converted;
    }

    //endregion
}
