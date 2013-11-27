<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.4
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

use axelitus\Base\Exceptions\NotImplementedException;

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
     * @param bool|array $value1 The value to which the operation should be applied.
     * @param bool|array $_ ... More values to apply the operation to.
     *
     * @return bool|array The result of applying the operation to the given value(s).
     *                    If only a boolean is given, the result will be a boolean. If multiple booleans are
     *                    given, the result will be an array of booleans. If only one array of booleans is
     *                    given, the result will be an array of booleans. If multiple arrays are given, the
     *                    result will be an array of arrays of booleans. Any combination of booleans and array
     *                    of booleans will return an array containing a combination of booleans and array of
     *                    booleans in the order in which they were given.
     * @throws \InvalidArgumentException
     */
    public static function opNot($value1, $_ = null)
    {
        $ret = [];
        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $tmp = [];
                foreach ($arg as $item) {
                    if (!static::is($item)) {
                        throw new \InvalidArgumentException("All array values must be of type bool.");
                    }
                    $tmp[] = !$item;
                }
                $ret[] = $tmp;
            } elseif (static::is($arg)) {
                $ret[] = !$arg;
            } else {
                throw new \InvalidArgumentException("All parameters must be of type bool.");
            }
        }

        return (count($ret) > 1) ? $ret : $ret[0];
    }

    //endregion

    //region AND operation

    public static function valAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region OR operation

    public static function valOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region EQ operation

    public static function valEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region XOR operation

    public static function valXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion
}
