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

namespace axelitus\Base\Primitives\Numeric\Types;

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class PrimitiveInt
 *
 * Defines the int primitives.
 *
 * @package axelitus\Base\Primitives\Numeric\Types
 */
abstract class PrimitiveInt extends PrimitiveNumeric
{
    //region Instance Methods/Functions

    /**
     * Validates the given primitive value.
     *
     * This function is automatically called from the parent class automatically.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateValue($value)
    {
        return parent::validateValue($value) and $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveInt');
    }

    //endregion

    //region Static Methods/Functions

    /**
     * Determines if the given value is of this primitive type.
     *
     * @param mixed $var
     *
     * @return bool
     */
    public static function is($var)
    {
        return (static::isSimple($var) and (is_int($var) or (strval(intval($var)) === strval($var)))) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveInt'
        );
    }

    /**
     * Gets the native integer of a given value. If the given value is of type PrimitiveInt,
     * the object's value is returned, if it's an integer, the integer is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveInt $value The value to get the native integer value from.
     *
     * @throws \InvalidArgumentException
     * @return int The native integer value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be an integer or instance derived from PrimitiveInt.");
        }

        return (is_object($value) and ($value instanceof PrimitiveInt)) ? $value->value() : $value;
    }

    /**
     * Determines if two given values are equal.
     *
     * For the sake of this implementation there is no distinction between the == (equal) operator
     * and the === (identical) operator.
     *
     * @param int|PrimitiveInt $a The first of the values to compare.
     * @param int|PrimitiveInt $b The second of the values to compare.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if both values are integers and are equal, false otherwise.
     */
    public static function areEqual($a, $b)
    {
        try {
            $a = static::native($a);
            $b = static::native($b);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$a and \$b parameters must be integers or instances derived from PrimitiveInt.");
        }

        return $a == $b;
    }

    /**
     * Generates a random integer number between min and max.
     *
     * @param int|PrimitiveInt      $min  Lower bound (inclusive)
     * @param int|PrimitiveInt      $max  Upper bound(inclusive)
     * @param null|int|PrimitiveInt $seed Random generator seed
     *
     * @return int|false A random integer value between min (or 0) and max (or 1, inclusive), or FALSE if max
     *             is less than min.
     * @throws \InvalidArgumentException
     */
    public static function random($min = 0, $max = 1, $seed = null)
    {
        try {
            $min = static::native($min);
            $max = static::native($max);
            $seed = (is_null($seed))? $seed : static::native($seed);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$min, \$max and \$seed parameters must be integers or instances derived from PrimitiveInteger.");
        }

        if (!is_null($seed) and static::is($seed)) {
            mt_srand($seed);
        }

        $rand = mt_rand($min, $max);

        // unseed (random reseed) random generator
        mt_srand();

        return $rand;
    }

    /**
     * Tests if an integer is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param int|PrimitiveInt $value          The value to test in range.
     * @param int|PrimitiveInt $lower          The range's lower limit.
     * @param int|PrimitiveInt $upper          The range's upper limit.
     * @param bool             $lowerExclusive Whether the lower bound is exclusive.
     * @param bool             $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        try {
            $value = static::native($value);
            $lower = static::native($lower);
            $upper = static::native($upper);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be integers or instances derived from PrimitiveInt.");
        }

        $lowerLimit = min($lower, $upper);
        if (!($lowerTest = ($lowerExclusive) ? $lowerLimit < $value : $lowerLimit <= $value)) {
            return false;
        }

        $upperLimit = max($lower, $upper);
        if (!($upperTest = ($upperExclusive) ? $upperLimit > $value : $upperLimit >= $value)) {
            return false;
        }

        return true;
    }

    /**
     * Tests if an integer is inside a range.
     *
     * It's an alias for Int::inRange($value, $lower, $upper, false, false)
     *
     * @param int|PrimitiveInt $value The value to test in range.
     * @param int|PrimitiveInt $lower The range's lower limit.
     * @param int|PrimitiveInt $upper The range's upper limit.
     *
     * @throws \InvalidArgumentException
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @see Int::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        try {
            $value = static::native($value);
            $lower = static::native($lower);
            $upper = static::native($upper);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be integers or instances derived from PrimitiveInt.");
        }

        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if an integer is between a range.
     *
     * It's an alias for Int::inRange($value, $lower, $upper, true, true)
     *
     * @param int|PrimitiveInt $value The value to test in range.
     * @param int|PrimitiveInt $lower The range's lower limit.
     * @param int|PrimitiveInt $upper The range's upper limit.
     *
     * @throws \InvalidArgumentException
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @see Int::inRange
     */
    public static function between($value, $lower, $upper)
    {
        try {
            $value = static::native($value);
            $lower = static::native($lower);
            $upper = static::native($upper);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be integers or instances derived from PrimitiveInt.");
        }

        return static::inRange($value, $lower, $upper, true, true);
    }

    //endregion
}
