<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.6.0
 */

namespace axelitus\Base;

/**
 * Class Bool
 *
 * Boolean operations.
 *
 * @package axelitus\Base
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

            // Use true so that the expressions of the switch will evaluate to
            // (true && (result of expression)) effectively entering the first
            // case in which the expression evaluates to true.
            switch (true) {
                case ($value == 'true' || $value == '1' || $value == 'on' || $value == 'yes' || $value == 'y'):
                case ($value == 'false' || $value == '0' || $value == 'off' || $value == 'no' || $value == 'n'):
                    return true;
                    break;
                default:
                    return false;
            }
        }

        return false;
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
        if (!is_string($input) || $input == '') {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        // This function is case insensitive so let's compare to the lower-cased input string.
        $input = strtolower($input);

        // Use true so that the expressions of the switch will evaluate to
        // (true && (result of expression)) effectively entering the first
        // case in which the expression evaluates to true.
        switch (true) {
            case ($input == 'true' || $input == '1'):
                $ret = true;
                break;
            case ($input == 'false' || $input == '0'):
                $ret = false;
                break;
            default:
                throw new \RuntimeException("The \$input string cannot be parsed because it does not match 'true', 'false', '1' or '0'.");
                break;
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
        if (!is_string($input) || $input == '') {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        // This function is case insensitive so let's compare to the lower-cased input string.
        $input = strtolower($input);

        // Use true so that the expressions of the switch will evaluate to
        // (true && (result of expression)) effectively entering the first
        // case in which the expression evaluates to true.
        switch (true) {
            case ($input == 'true' || $input == '1' || $input == 'on' || $input == 'yes' || $input == 'y'):
                $ret = true;
                break;
            case ($input == 'false' || $input == '0' || $input == 'off' || $input == 'no' || $input == 'n'):
                $ret = false;
                break;
            default:
                throw new \RuntimeException("The \$input parameter did not match any of the valid strings that can be parsed.");
                break;
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
     * @return array The result of applying the operation to the items of the array(s).
     * @throws \InvalidArgumentException
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
     * Applies the AND operation to the given value(s).
     *
     * Consistent input values must be given, if the first value is bool, then all other values must be bool.
     * The AND operation is applied in chain for all values, one after another in the order they were given.
     * If the first value is array, then all other values must be array. If only one array is given, the AND
     * operation is applied in chain for all items in the input array in the order they are. If multiple arrays
     * are given, the AND operation is applied individually for each array, returning an array of results, one
     * result per input array (the arrays are not mixed).
     *
     * @param bool|array $value1 The value to which the operation should be applied.
     * @param bool|array $_      More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the given value(s).
     * @throws \InvalidArgumentException
     */
    public static function opAnd($value1, $_ = null)
    {
        $reset = true;
        $ret = [];
        $args = func_get_args();

        if (is_array($value1)) {
            if (count($args) > 1) {
                foreach ($args as $arr) {
                    if (!is_array($arr)) {
                        throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case array).");
                    }

                    $ret[] = static::opAnd($arr);
                }
            } else {
                $tmp = $reset;
                foreach ($value1 as $arg) {
                    if (!static::is($arg)) {
                        throw new \InvalidArgumentException("All array values must be of type bool.");
                    }
                    $tmp = ($tmp && $arg);
                }
                $ret[] = $tmp;
            }
        } elseif (static::is($value1)) {
            $tmp = $reset;
            foreach ($args as $arg) {
                if (!static::is($arg)) {
                    throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case bool).");
                }
                $tmp = ($tmp && $arg);
            }
            $ret[] = $tmp;
        } else {
            throw new \InvalidArgumentException("All values must be of type bool or array.");
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region OR operation

    /**
     * Applies the OR operation to the given value(s).
     *
     * Consistent input values must be given, if the first value is bool, then all other values must be bool.
     * The OR operation is applied in chain for all values, one after another in the order they were given.
     * If the first value is array, then all other values must be array. If only one array is given, the OR
     * operation is applied in chain for all items in the input array in the order they are. If multiple arrays
     * are given, the OR operation is applied individually for each array, returning an array of results, one
     * result per input array (the arrays are not mixed).
     *
     * @param bool|array $value1 The value to which the operation should be applied.
     * @param bool|array $_      More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the given value(s).
     * @throws \InvalidArgumentException
     */
    public static function opOr($value1, $_ = null)
    {
        $reset = false;
        $ret = [];
        $args = func_get_args();

        if (is_array($value1)) {
            if (count($args) > 1) {
                foreach ($args as $arr) {
                    if (!is_array($arr)) {
                        throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case array).");
                    }

                    $ret[] = static::opOr($arr);
                }
            } else {
                $tmp = $reset;
                foreach ($value1 as $arg) {
                    if (!static::is($arg)) {
                        throw new \InvalidArgumentException("All array values must be of type bool.");
                    }
                    $tmp = ($tmp || $arg);
                }
                $ret[] = $tmp;
            }
        } elseif (static::is($value1)) {
            $tmp = $reset;
            foreach ($args as $arg) {
                if (!static::is($arg)) {
                    throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case bool).");
                }
                $tmp = ($tmp || $arg);
            }
            $ret[] = $tmp;
        } else {
            throw new \InvalidArgumentException("All values must be of type bool or array.");
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region EQ operation

    /**
     * Applies the EQ operation to the given value(s).
     *
     * Consistent input values must be given, if the first value is bool, then the second values must be bool.
     * If bool values are given, only two arguments are allowed. If the first value is array, then all other
     * values must be array. Each array must contain only two bool values on which the EQ operation will be
     * applied. If multiple arrays are given, the EQ operation is applied individually for each array, returning
     * an array of results, one result per input array (the arrays are not mixed).
     *
     * @param bool|array $value1 The value to which the operation should be applied.
     * @param bool|array $_      More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the given value(s).
     * @throws \InvalidArgumentException
     */
    public static function opEq($value1, $_ = null)
    {
        $ret = [];
        $args = func_get_args();

        if (is_array($value1)) {
            foreach ($args as $arg) {
                if (!is_array($arg) || count($arg) != 2) {
                    throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case array).");
                }

                if (!static::is($arg[0]) || !static::is($arg[1])) {
                    throw new \InvalidArgumentException("All array values must be of type bool.");
                }

                $ret[] = ($arg[0] == $arg[1]);
            }
        } elseif (static::is($value1)) {
            if (count($args) != 2) {
                throw new \InvalidArgumentException("Only two booleans at a time are allowed.");
            }

            if (!static::is($args[1])) {
                throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case bool).");
            }

            $ret[] = ($value1 == $args[1]);
        } else {
            throw new \InvalidArgumentException("All values must be of type bool or array.");
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region XOR operation

    /**
     * Applies the XOR operation to the given value(s).
     *
     * Consistent input values must be given, if the first value is bool, then the second values must be bool.
     * If bool values are given, only two arguments are allowed. If the first value is array, then all other
     * values must be array. Each array must contain only two bool values on which the XOR operation will be
     * applied. If multiple arrays are given, the XOR operation is applied individually for each array, returning
     * an array of results, one result per input array (the arrays are not mixed).
     *
     * @param bool|array $value1 The value to which the operation should be applied.
     * @param bool|array $_      More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the given value(s).
     * @throws \InvalidArgumentException
     */
    public static function opXor($value1, $_ = null)
    {
        $ret = [];
        $args = func_get_args();

        if (is_array($value1)) {
            foreach ($args as $arg) {
                if (!is_array($arg) || count($arg) != 2) {
                    throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case array).");
                }

                if (!static::is($arg[0]) || !static::is($arg[1])) {
                    throw new \InvalidArgumentException("All array values must be of type bool.");
                }

                $ret[] = ($arg[0] != $arg[1]);
            }
        } elseif (static::is($value1)) {
            if (count($args) != 2) {
                throw new \InvalidArgumentException("Only two booleans at a time are allowed.");
            }

            if (!static::is($args[1])) {
                throw new \InvalidArgumentException("Cannot mix value types. All values must be of the same type (in this case bool).");
            }

            $ret[] = ($value1 != $args[1]);
        } else {
            throw new \InvalidArgumentException("All values must be of type bool or array.");
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion
}
