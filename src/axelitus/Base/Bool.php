<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.1
 */

namespace axelitus\Base;

/**
 * Class Bool
 *
 * Boolean operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Bool
{
    //region Value Testing

    /**
     * Tests if the given value is a bool or not.
     *
     * This function considers 0 and 1 as "true" booleans.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a bool or 0 or 1, false otherwise.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function is($value)
    {
        return ($value === true || $value === false || $value === 0 || $value === 1);
    }

    /**
     * Tests if the given value is a bool or not.
     *
     * This function considers also the strings 'true', 'false', 'on', 'off', 'yes', 'no', 'y', 'n', '1', '0'
     * to be booleans. The function is NOT case sensitive.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a bool or 0 or 1, false otherwise.
     */
    public static function extIs($value)
    {
        if (static::is($value)) {
            return true;
        }

        if (is_string($value)) {
            // This function is case insensitive so let's compare to the lower-cased input string.
            $value = strtolower($value);

            return (static::isTrueStrExt($value) || static::isFalseStrExt($value));
        }

        return false;
    }

    /**
     * Determines if the given string is considered as a true value.
     *
     * @param string $str The string to test.
     *
     * @return bool Returns true if the given string is considered as a true boolean value, false otherwise.
     */
    protected static function isTrueStr($str)
    {
        return ($str === 'true' || $str === '1');
    }

    /**
     * Determines if the given string is considered as an extended true value.
     *
     * @param string $str The string to test.
     *
     * @return bool Returns true if the given string is considered as an extended true boolean value, false otherwise.
     */
    protected static function isTrueStrExt($str)
    {
        return (static::isTrueStr($str) || $str === 'on' || $str === 'yes' || $str === 'y');
    }

    /**
     * Determines if the given string is considered as a false value.
     *
     * @param string $str The string to test.
     *
     * @return bool Returns true if the given string is considered as a false boolean value, false otherwise.
     */
    protected static function isFalseStr($str)
    {
        return ($str === 'false' || $str === '0');
    }

    /**
     * Determines if the given string is considered as an extended false value.
     *
     * @param string $str The string to test.
     *
     * @return bool Returns true if the given string is considered as an extended false boolean value, false otherwise.
     */
    protected static function isFalseStrExt($str)
    {
        return (static::isFalseStr($str) || $str === 'off' || $str === 'no' || $str === 'n');
    }

    //endregion

    //region Comparing

    /**
     * Compares two bool values.
     *
     * The returning value contains the actual value difference.
     *
     * @param bool $bool1 The left operand.
     * @param bool $bool2 The right operand.
     *
     * @return int Returns -1 if $bool1=false and $bool2=true, =0 if $bool1 == $bool2, 1 if $bool1=true and $bool2=false
     * @throws \InvalidArgumentException
     */
    public static function compare($bool1, $bool2)
    {
        if (!static::is($bool1) || !static::is($bool2)) {
            throw new \InvalidArgumentException(
                "The \$bool1 and \$bool2 parameters must be of type bool."
            );
        }

        return ((int)$bool1 - (int)$bool2);
    }

    //endregion

    //region Conversion

    /**
     * Converts a given value to bool.
     *
     * If the given value is not identified as bool by {@link Bool::extIs} the default value is returned.
     *
     * @param mixed $value   The value to convert from.
     * @param mixed $default The default value.
     *
     * @return mixed Returns the converted bool value or the default value.
     */
    public static function from($value, $default = null)
    {
        if (!static::extIs($value)) {
            return $default;
        }

        return static::extParse($value);
    }

    //endregion

    //region Parsing

    /**
     * Parses the input string into a bool.
     *
     * The only strings that this function parses to boolean are 'true', 'false', '1' and '0'.
     * This function is NOT case sensitive.
     *
     * @param string $input The string to be parsed.
     *
     * @return bool The parsed bool.
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public static function parse($input)
    {
        if (Str::isNotOrEmpty($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        // This function is case insensitive so let's compare to the lower-cased input string.
        $input = strtolower($input);

        // Use true so that the expressions of the switch will evaluate to
        // (true && (result of expression)) effectively entering the first
        // case in which the expression evaluates to true.
        switch (true) {
            case static::isTrueStr($input):
                $ret = true;
                break;
            case static::isFalseStr($input):
                $ret = false;
                break;
            default:
                throw new \RuntimeException(
                    "The \$input string cannot be parsed because it does not match 'true', 'false', '1' or '0'."
                );
        }

        return $ret;
    }

    /**
     * Parses the input string into a bool.
     *
     * This function allows for an extended set of strings that are parsed as booleans:
     * 'true', '1', 'on', 'yes', 'y', 'false', '0', 'off', 'no', 'n'.
     * This function is NOT case sensitive.
     *
     * @param string $input The string to be parsed.
     *
     * @return bool The parsed bool.
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public static function extParse($input)
    {
        if (Str::isNotOrEmpty($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        // This function is case insensitive so let's compare to the lower-cased input string.
        $input = strtolower($input);

        // Use true so that the expressions of the switch will evaluate to
        // (true && (result of expression)) effectively entering the first
        // case in which the expression evaluates to true.
        switch (true) {
            case static::isTrueStrExt($input):
                $ret = true;
                break;
            case static::isFalseStrExt($input):
                $ret = false;
                break;
            default:
                throw new \RuntimeException(
                    "The \$input parameter did not match any of the valid strings that can be parsed."
                );
        }

        return $ret;
    }

    //endregion

    //region NOT operation

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
    public static function valueNot($value1, $_ = null)
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
    public static function arrayNot(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg)) {
                throw new \InvalidArgumentException("All parameters must be of type array.");
            }

            $tmp = call_user_func_array('static::valueNot', $arg);
            $ret[] = (is_array($tmp)) ? $tmp : [$tmp];
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region AND operation

    /**
     * Applies the AND operation to the given values.
     *
     * The function is optimized to return early (if a false is found the function returns false immediately),
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
    public static function valueAnd($value1, $value2, $_ = null)
    {
        if (!static::is($value1) || !static::is($value2)) {
            throw new \InvalidArgumentException("All parameters must be of type bool.");
        }

        $ret = ($value1 && $value2);
        $args = array_slice(func_get_args(), 2);
        while ($ret && ($bool = array_shift($args)) !== null) {
            if (!static::is($bool)) {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }

            $ret = ($ret && $bool);
        }

        return $ret;
    }

    /**
     * Applies the AND operation to the items of the given array(s).
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
    public static function arrayAnd(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg) || count($arg) < 2) {
                throw new \InvalidArgumentException(
                    "All parameters must be of type array and must contain at least 2 items."
                );
            }

            $ret[] = call_user_func_array('static::valueAnd', $arg);
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region OR operation

    /**
     * Applies the OR operation to the given values.
     *
     * The function is optimized to return early (if a true is found the function returns true immediately),
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
    public static function valueOr($value1, $value2, $_ = null)
    {
        if (!static::is($value1) || !static::is($value2)) {
            throw new \InvalidArgumentException("All parameters must be of type bool.");
        }

        $ret = ($value1 || $value2);
        $args = array_slice(func_get_args(), 2);
        while (!$ret && ($bool = array_shift($args)) !== null) {
            if (!static::is($bool)) {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }

            $ret = ($ret || $bool);
        }

        return $ret;
    }

    /**
     * Applies the OR operation to the items of the given array(s).
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
    public static function arrayOr(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg) || count($arg) < 2) {
                throw new \InvalidArgumentException(
                    "All parameters must be of type array and must contain at least 2 items."
                );
            }

            $ret[] = call_user_func_array('static::valueOr', $arg);
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region EQ operation

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
    public static function valueEq($value1, $value2, $_ = null)
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
    public static function arrayEq(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg) || count($arg) < 2) {
                throw new \InvalidArgumentException(
                    "All parameters must be of type array and must contain at least 2 items."
                );
            }

            $ret[] = call_user_func_array('static::valueEq', $arg);
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region XOR operation

    /**
     * Applies the XOR operation to the given values.
     *
     * The function is optimized to return early (if a value not equal the function returns false immediately),
     * therefore we can't assume that all values had been tested for validity. The values will be tested against
     * for exclusiveness only to the first value, thus if true is returned it does not mean that all values are
     * exclusively different to one another, just that they are not equal to the first given value.
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
    public static function valueXor($value1, $value2, $_ = null)
    {
        if (!static::is($value1) || !static::is($value2)) {
            throw new \InvalidArgumentException("All parameters must be of type bool.");
        }

        $ret = ($value1 != $value2);
        $args = array_slice(func_get_args(), 2);
        while ($ret && ($bool = array_shift($args)) !== null) {
            if (!static::is($bool)) {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }

            $ret = ($value1 != $bool);
        }

        return $ret;
    }

    /**
     * Applies the XOR operation to the items of the given array(s).
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
    public static function arrayXor(array $value1, array $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_array($arg) || count($arg) < 2) {
                throw new \InvalidArgumentException(
                    "All parameters must be of type array and must contain at least 2 items."
                );
            }

            $ret[] = call_user_func_array('static::valueXor', $arg);
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion
}
