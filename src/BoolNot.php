<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base;

/**
 * Class BoolNot
 *
 * Boolean NOT operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BoolNot extends Bool
{
    // region: NOT operation

    /**
     * Applies the NOT operation to the given value(s).
     *
     * @param bool $value1 The value to apply the operation to.
     * @param bool $_      More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the value(s).
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function val($value1, $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!static::is($arg)) {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }

            $ret[] = !$arg;
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    /**
     * Applies the NOT operation to each of the items of the given array(s).
     *
     * @param array $value1 The array to apply the operation to its items.
     * @param array $_      More arrays to apply the operation to its items.
     *
     * @return array The result of applying the operation to the items of given the array(s).
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function arr(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg)) {
                throw new \InvalidArgumentException("All parameters must be of type array.");
            }

            $tmp = call_user_func_array('static::val', $arg);
            $ret[] = (is_array($tmp)) ? $tmp : [$tmp];
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    // endregion
}