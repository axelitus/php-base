<?php
/**
 * axelitus/base - Primitive extensions and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.4
 */

namespace axelitus\Base\Primitives\Numeric;

use axelitus\Base\Exceptions\NotImplementedException;
use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveNumeric
 *
 * Defines the numeric primitives.
 *
 * @package axelitus\Base\Primitives\Numeric
 */
abstract class PrimitiveNumeric extends Primitive
{
    //region Instance Methods/Functions

    /**
     * Validates the given primitive value.
     *
     * This function is automatically called from the parent class automatically.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveNumeric');
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
        return is_numeric($var) or is_a($var, __NAMESPACE__ . '\PrimitiveNumeric');
    }

    /**
     * Gets the native numeric of a given value. If the given value is of type PrimitiveNumeric,
     * the object's value is returned, if it's a numeric, the numeric is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveNumeric $value The value to get the native numeric value from.
     *
     * @throws \InvalidArgumentException
     * @return int|float The native numeric value.
     */
    public static function native($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a numeric or instance derived from PrimitiveNumeric.");
        }

        return (is_object($value) and ($value instanceof PrimitiveNumeric)) ? $value->getValue() : $value;
    }

    /**
     * Determines if two given values are equal.
     *
     * For the sake of this implementation there is no distinction between the == (equal) operator
     * and the === (identical) operator.
     *
     * @param int|float|PrimitiveNumeric $a The first of the values to compare.
     * @param int|float|PrimitiveNumeric $b The second of the values to compare.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     */
    public static function areEqual($a, $b)
    {
        try {
            $a = static::native($a);
            $b = static::native($b);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$a and \$b parameters must be numeric or instances derived from PrimitiveNumeric.");
        }

        return $a == $b;
    }

    /**
     * Does a numeric sum operation to the given operand(s).
     *
     * @param int|float|PrimitiveNumeric $operand,... The operand(s) to operate with
     *
     * @return float|int The resulting sum
     * @throws \InvalidArgumentException
     */
    public static function doSum($operand)
    {
        $chain = 0;
        $args = func_get_args();

        foreach ($args as $arg) {
            try {
                if (is_array($arg)) {
                    foreach ($arg as $a) {
                        $chain += static::native($a);
                    }
                } else {
                    $chain += static::native($arg);
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
            }
        }

        return $chain;
    }

    /**
     * Does a numeric rest operation to the given operand(s). The first operand will be taken as base.
     *
     * @param int|float|PrimitiveNumeric $operand,... The operand(s) to operate with
     *
     * @return float|int The resulting sum
     * @throws \InvalidArgumentException
     */
    public static function doRest($operand)
    {
        $args = func_get_args();
        if (count($args) < 1) {
            return 0;
        }

        try {
            $chain = array_shift($args);
            $chain = static::native($chain);
        } catch (\InvalidArgumentException $ex) {
            if(is_array($chain) and count($chain) > 0) {
                try {
                    $tmp = static::native(array_shift($chain));
                    array_unshift($args, $chain);
                    $chain = $tmp;
                } catch(\InvalidArgumentException $ex) {
                    throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
                }
            }
        }

        foreach ($args as $arg) {
            try {
                if (is_array($arg)) {
                    foreach ($arg as $a) {
                        $chain -= static::native($a);
                    }
                } else {
                    $chain -= static::native($arg);
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
            }
        }

        return $chain;
    }

    /**
     * Does a numeric multiplication operation to the given operand(s).
     *
     * @param int|float|PrimitiveNumeric $operand,... The operand(s) to operate with
     *
     * @return float|int The resulting sum
     * @throws \InvalidArgumentException
     */
    public static function doMult($operand)
    {
        $chain = 1;
        $args = func_get_args();

        foreach ($args as $arg) {
            if ($chain == 0) {
                return 0;
            }

            try {
                if (is_array($arg)) {
                    foreach ($arg as $a) {
                        $chain *= static::native($a);
                    }
                } else {
                    $chain *= static::native($arg);
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
            }
        }

        return $chain;
    }

    /**
     * Does a numeric division operation to the given operand(s). The first operand will be taken as base.
     *
     * @param int|float|PrimitiveNumeric $operand,... The operand(s) to operate with
     *
     * @return float|int The resulting sum
     * @throws \InvalidArgumentException
     */
    public static function doDiv($operand)
    {
        $args = func_get_args();
        if (count($args) < 1) {
            return 0;
        }

        try {
            $chain = array_shift($args);
            $chain = static::native($chain);
        } catch (\InvalidArgumentException $ex) {
            if(is_array($chain) and count($chain)) {
                try {
                    $tmp = static::native(array_shift($chain));
                    array_unshift($args, $chain);
                    $chain = $tmp;
                } catch(\InvalidArgumentException $ex) {
                    throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
                }
            }
        }

        foreach ($args as $arg) {
            try {
                if (is_array($arg)) {
                    foreach ($arg as $a) {
                        if(($a = static::native($a)) == 0) {
                            throw new \InvalidArgumentException("Division by zero found. The divide parameters cannot be zero.");
                        }
                        $chain /= $a;
                    }
                } else {
                    if(($arg = static::native($arg)) == 0) {
                        throw new \InvalidArgumentException("Division by zero found. The divide parameters cannot be zero.");
                    }
                    $chain /= $arg;
                }
            } catch (\InvalidArgumentException $ex) {
                throw new \InvalidArgumentException("The parameters must be numeric or instances derived from PrimitiveNumeric.");
            }
        }

        return $chain;
    }

    public static function doMod($operand, $mod)
    {
        throw new NotImplementedException("This operation has not yet been implemented.");
    }

    public static function doPow($operand)
    {
        throw new NotImplementedException("This operation has not yet been implemented.");
    }

    //endregion
}
