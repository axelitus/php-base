<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.3
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base\Primitives\Boolean;

use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveBoolean
 *
 * Defines the boolean primitives.
 *
 * @package axelitus\Base\Primitives\Boolean
 */
abstract class PrimitiveBoolean extends Primitive
{
    //region Instance Methods/Functions

    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveBoolean');
    }

    //endregion

    //region Static Methods/Functions

    /**
     * Determines if $var is of the primitive type numeric (int or float).
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is of the type numeric, false otherwise.
     */
    public static function is($var)
    {
        return (static::isSimple($var) and (is_bool($var) or $var === 0 or $var === 1)) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveBoolean'
        );
    }

    /**
     * Gets the native boolean of a given value. If the given value is of type PrimitiveBoolean,
     * the object's value is returned, if it's a boolean, the boolean is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveBoolean $value The value to get the native boolean value from.
     *
     * @throws \InvalidArgumentException
     * @return bool The native boolean value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a boolean or instance derived from PrimitiveBoolean.");
        }

        return (is_object($value) and ($value instanceof PrimitiveBoolean)) ? $value->value() : $value;
    }

    /**
     * Determines if two given values are equal.
     *
     * For the sake of this implementation there is no distinction between the == (equal) operator
     * and the === (identical) operator.
     *
     * @param bool|PrimitiveBoolean $a The first of the values to compare.
     * @param bool|PrimitiveBoolean $b The second of the values to compare.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if both values are booleans and are equal, false otherwise.
     */
    public static function areEqual($a, $b)
    {
        try {
            $a = static::native($a);
            $b = static::native($b);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$a and \$b parameters must be booleans or instances derived from PrimitiveBoolean.");
        }

        return $a == $b;
    }

    /**
     * Applies the boolean NOT operation to the given input value.
     *
     * @param bool|PrimitiveBoolean $input The value to apply the NOT operation to.
     *
     * @return bool Returns true if $input was false, and false if $input was true.
     * @throws \InvalidArgumentException
     */
    public static function doNot($input)
    {
        try {
            $input = static::native($input);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$input parameter must be a boolean or instance derived from PrimitiveBoolean.");
        }

        return !$input;
    }

    /**
     * Applies the boolean AND operation to the given input values.
     *
     * @param bool|PrimitiveBoolean|array $input,... The input booleans or array of booleans to apply the AND operation to.
     *
     * @return bool Returns true if all values are true, false otherwise.
     * @throws \InvalidArgumentException
     */
    public static function doAnd($input)
    {
        $chain = true;
        $args = func_get_args();

        foreach ($args as $arg) {
            try {
                if (is_array($arg)) {
                    foreach ($arg as $b) {
                        $chain &= static::native($b);
                    }
                } else {
                    $chain &= $arg;
                }

                if (!$chain) {
                    return false;
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be booleans or instances derived from PrimitiveBoolean.");
            }
        }

        return true;
    }

    /**
     * Applies the boolean OR operation to the given input values.
     *
     * @param bool|PrimitiveBoolean|array $input,... The input booleans or array of booleans to apply the OR operation to.
     *
     * @return bool Returns true if at least one of the values is true, false otherwise.
     * @throws \InvalidArgumentException
     */
    public static function doOr($input)
    {
        $chain = false;
        $args = func_get_args();

        foreach ($args as $arg) {
            try {
                if (is_array($arg)) {
                    foreach ($arg as $b) {
                        $chain |= static::native($b);
                    }
                } else {
                    $chain |= $arg;
                }

                if ($chain) {
                    return true;
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be booleans or instances derived from PrimitiveBoolean.");
            }
        }

        return false;
    }

    /**
     * Applies the boolean EQ (equality) operation to the given $a and $b values or array of values.
     *
     * @param bool|PrimitiveBoolean|array $a The first EQ operand or array of operands.
     * @param bool|PrimitiveBoolean|array $b The second EQ operand or array of operands.
     *
     * @return bool|array Returns true if $a and $b are equal, false otherwise (or an array of results).
     * @throws \InvalidArgumentException
     */
    public static function doEq($a, $b)
    {
        $ret = [];

        try {
            $source = static::native($a);
        } catch (\InvalidArgumentException $ex) {
            if (!is_array($a)) {
                throw new \InvalidArgumentException("The \$a parameter must be a boolean or an instance derived from PrimitiveBoolean or an array of booleans or instances derived from PrimitiveBoolean.");
            }

            $source = $a;
        }

        try {
            $bind = static::native($b);
        } catch (\InvalidArgumentException $ex) {
            if (!is_array($b)) {
                throw new \InvalidArgumentException("The \$b parameter must be a boolean or an instance derived from PrimitiveBoolean or an array of booleans or instances derived from PrimitiveBoolean.");
            }

            $bind = $b;
        }

        if (is_array($source)) {
            if (is_array($bind)) {
                if (($count = count($source)) !== count($bind)) {
                    throw new \InvalidArgumentException("The \$a and \$b arrays must have the same amount of elements.");
                }

                for ($i = 0; $i < $count; $i++) {
                    $ret[] = ($bind[$i] == $source[$i]);
                }
            } else {
                foreach ($source as $s) {
                    $ret[] = ($bind == $s);
                }
            }
        } else {
            if (is_array($bind)) {
                foreach ($bind as $b) {
                    $ret[] = ($b == $source);
                }
            } else {
                $ret = ($bind == $source);
            }
        }

        return $ret;
    }

    /**
     * Applies the boolean XOR operation to the given $a and $b values or array of values.
     *
     * @param bool|PrimitiveBoolean|array $a The first XOR operand or array of operands.
     * @param bool|PrimitiveBoolean|array $b The second XOR operand or array of operands.
     *
     * @return bool Returns true if $a and $b are different, false otherwise (or an array of results).
     * @throws \InvalidArgumentException
     */
    public static function doXor($a, $b)
    {
        $ret = static::doEq($a, $b);
        if (is_array($ret)) {
            foreach ($ret as &$r) {
                $r = static::doNot($r);
            }
        } else {
            $ret = static::doNot($ret);
        }

        return $ret;
    }

    //endregion
}
