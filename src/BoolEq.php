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
 * Class BoolEq
 *
 * Boolean EQ operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BoolEq extends Bool
{
    // region: EQ operation

    /**
     * Applies the EQ operation to the given values.
     *
     * The function is optimized to return early (if a value is not equal the function returns false immediately),
     * therefore we can't assume that all values had been tested for validity.
     *
     * @param bool $value1 The left operand to apply the operation to.
     * @param bool $value2 The right operand to apply the operation to.
     * @param null $_      More values to apply the operation in cascade.
     *
     * @return bool The result of applying the operation to the given values.
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.CamelCaseParameterName)
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function val($value1, $value2, $_ = null)
    {
        if (!static::is($value1) || !static::is($value2)) {
            throw new \InvalidArgumentException("All parameters must be of type bool.");
        }

        $ret = ($value1 == $value2);
        $args = array_slice(func_get_args(), 2);
        while ($ret && ($bool = array_shift($args)) !== null) {
            if (!static::is($bool)) {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }

            $ret = ($value1 == $bool);
        }

        return $ret;
    }

    /**
     * Applies the EQ operation to the items of the given array(s).
     *
     * If only one array is given, the result will be a bool instead of an array.
     *
     * @param array $value1 The array to apply the operation to its items.
     * @param array $_      More arrays to apply the operation to its items.
     *
     * @return bool|array The result of applying the operation to the items of the given array(s).
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
            if (!is_array($arg) || count($arg) < 2) {
                throw new \InvalidArgumentException(
                    "All parameters must be of type array and must contain at least 2 items."
                );
            }

            $ret[] = call_user_func_array('static::val', $arg);
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    // endregion
}