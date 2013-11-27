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
        return (static::is($value) || (is_string($value) && Str::isOneOf(
                $value,
                ['true', 'false', 'on', 'off', 'yes', 'no', 'y', 'n', '1', '0'],
                false
            )));
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

    public static function extParse($input)
    {
        if (!is_string($input) || ($input != '0' && empty($input))) {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        switch ($input = strtolower($input)) {
            case 'true':
            case 'on':
            case 'yes':
            case 'y':
            case '1':
                $ret = true;
                break;
            case 'false':
            case 'off':
            case 'no':
            case 'n':
            case '0':
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

    public static function valNot($value1, $value2 = null, $_ = null)
    {
        if (static::isNot($value1)) {
            throw new \InvalidArgumentException("All arguments must be of type bool.");
        }

        $args = array_slice(func_get_args(), 3);
        if ($value2 !== null) {
            if (static::isNot($value2)) {
                throw new \InvalidArgumentException("All arguments must be of type bool.");
            }
            $ret = [!$value1, !$value2];

            if ($_ !== null) {
                if (static::isNot($_)) {
                    throw new \InvalidArgumentException("All arguments must be of type bool.");
                }
                $ret[] = !$_;

                foreach ($args as $val) {
                    if (static::isNot($val)) {
                        throw new \InvalidArgumentException("All arguments must be of type bool.");
                    }
                    $ret[] = !$val;
                }
            }
        } else {
            $ret = !$value1;
        }

        return $ret;
    }

    public static function arrNot($value1, $value2 = null, $_ = null)
    {
        if (!is_array($value1)) {
            throw new \InvalidArgumentException("All arguments must be of type array.");
        }

        $ret = [];
        $args = array_slice(func_get_args(), 3);
        if ($value2 !== null) {
            if (!is_array($value2)) {
                throw new \InvalidArgumentException("All arguments must be of type array.");
            }

            // process value1 array
            // TODO: array_walk|array_map with anonymous function to validate?
            $tmp = [];
            foreach($value1 as $val){
                if(static::isNot($val)){
                    throw new \InvalidArgumentException("All items in the arrays must be of type bool.");
                }
                $tmp[] = !$val;
            }
            $ret[] = $tmp;

            // process value2 array
            // TODO: array_walk|array_map with anonymous function to validate?
            $tmp = [];
            foreach($value2 as $val){
                if(static::isNot($val)){
                    throw new \InvalidArgumentException("All items in the arrays must be of type bool.");
                }
                $tmp[] = !$val;
            }
            $ret[] = $tmp;

            if ($_ !== null) {
                if (!is_array($_)) {
                    throw new \InvalidArgumentException("All arguments must be of type array.");
                }
                // TODO: array_walk|array_map with anonymous function to validate?
                $tmp = [];
                foreach($_ as $val){
                    if(static::isNot($val)){
                        throw new \InvalidArgumentException("All items in the arrays must be of type bool.");
                    }
                    $tmp[] = !$val;
                }
                $ret[] = $tmp;

                foreach ($args as $arg) {
                    if (!is_array($arg)) {
                        throw new \InvalidArgumentException("All arguments must be of type array.");
                    }
                    // TODO: array_walk|array_map with anonymous function to validate?
                    $tmp = [];
                    foreach($arg as $val){
                        if(static::isNot($val)){
                            throw new \InvalidArgumentException("All items in the arrays must be of type bool.");
                        }
                        $tmp[] = !$val;
                    }
                    $ret[] = $tmp;
                }
            }
        } else {
            foreach($value1 as $val){
                if(static::isNot($val)){
                    throw new \InvalidArgumentException("All items in the arrays must be of type bool.");
                }
                $ret[] = !$val;
            }
        }

        return $ret;
    }

    public static function mixNot()
    {
        throw new NotImplementedException("This method is not yet implemented");
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
