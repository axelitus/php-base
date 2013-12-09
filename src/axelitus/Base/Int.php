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
 * Class Int
 *
 * Int operations.
 *
 * The function in this class are strict-typed (only accept int values).
 * If you want to accept both int and float use the {@link Num} class instead.
 *
 * @package axelitus\Base
 */
class Int
{
    //region Value Testing

    /**
     * Tests if the given value is an int (type test).
     *
     * This function uses the is_int() function to test.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is an int, false otherwise.
     */
    public static function is($value)
    {
        return is_int($value);
    }

    /**
     * Tests if the given value is an int or a string representation of an int.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the given value is an int or a representation of an int, false otherwise.
     */
    public static function extIs($value)
    {
        return static::is($value) || (is_string($value) && (strval(intval($value)) === strval($value)));
    }

    //endregion

    //region Comparing

    /**
     * Compares two int values.
     *
     * The returning value contains the actual value difference.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return int Returns <0 if $int1<$int2, =0 if $int1 == $int2, >0 if $int1>$int2
     * @throws \InvalidArgumentException
     */
    public static function compare($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException("The \$int1 and \$int2 parameters must be of type int.");
        }

        return ($int1 - $int2);
    }

    /**
     * Tests if two given int values are equal.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return bool Returns true if $int1 == $int2, false otherwise.
     */
    public static function equals($int1, $int2)
    {
        return (static::compare($int1, $int2) == 0);
    }

    /**
     * Tests if an integer is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param int  $value          The value to test in range.
     * @param int  $lower          The range's lower limit.
     * @param int  $upper          The range's upper limit.
     * @param bool $lowerExclusive Whether the lower bound is exclusive.
     * @param bool $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be of type int.");
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
     * @param int $value The value to test in range.
     * @param int $lower The range's lower limit.
     * @param int $upper The range's upper limit.
     *
     * @return bool Whether the value is inside the given range.
     * @see Int::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if an integer is between a range.
     *
     * It's an alias for Int::inRange($value, $lower, $upper, true, true)
     *
     * @param int $value The value to test in range.
     * @param int $lower The range's lower limit.
     * @param int $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see Int::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    //endregion

    //region Random

    /**
     * Generates a random integer number between min and max.
     *
     * @param int      $min  Lower bound (inclusive)
     * @param int      $max  Upper bound(inclusive)
     * @param null|int $seed Random generator seed
     *
     * @return int|false A random integer value between min (or 0) and max (or 1, inclusive), or FALSE if max
     *             is less than min.
     * @throws \InvalidArgumentException
     */
    public static function random($min = 0, $max = 1, $seed = null)
    {
        if (!static::is($min) || !static::is($max)) {
            throw new \InvalidArgumentException("The \$min and \$max parameters must be of type int.");
        }

        if ($min > $max) {
            trigger_error("The \$min value cannot be greater than the \$max value.", E_USER_WARNING);
            return false;
        }

        if (!is_null($seed) && static::is($seed)) {
            mt_srand($seed);
        }

        $rand = mt_rand($min, $max);

        // unseed (random reseed) random generator
        mt_srand();

        return $rand;
    }

    //endregion

    //region Basic numeric operations

    /**
     * Adds a number to another number.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return int The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function add($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException("The \$int1 and \$int2 parameters must be int.");
        }

        return ($int1 + $int2);
    }

    /**
     * Subtracts a number from another number.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return int The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function sub($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException("The \$int1 and \$int2 parameters must be int.");
        }

        return ($int1 - $int2);
    }

    /**
     * Multiplies a number by another number.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return int The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function mul($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException("The \$int1 and \$int2 parameters must be int.");
        }

        return ($int1 * $int2);
    }

    /**
     * Divides a number by another number.
     *
     * @param int $int1 The left operand.
     * @param int $int2 The right operand.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function div($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException("The \$int1 and \$int2 parameters must be int.");
        }

        if ($int2 == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$int2 parameter cannot be zero.");
        }

        return ($int1 / $int2);
    }

    /**
     * Raises a number to the power of another number.
     *
     * @param int $base The base number.
     * @param int $exponent The power exponent.
     *
     * @return int The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function pow($base, $exponent)
    {
        if (!static::is($base) || !static::is($exponent)) {
            throw new \InvalidArgumentException("The \$base and \$exponent parameters must be int.");
        }

        return pow($base, $exponent);
    }

    /**
     * Gets the remainder of a number divided by another number.
     *
     * @param int $base The left operand.
     * @param int $modulus The right operand.
     *
     * @return int The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function mod($base, $modulus)
    {
        if (!static::is($base) || !static::is($modulus)) {
            throw new \InvalidArgumentException("The \$base and \$modulus parameters must be int.");
        }

        if ($modulus == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$modulus parameter cannot be zero.");
        }

        return ($base % $modulus);
    }

    /**
     * Gets the square root of a number.
     *
     * @param int $base The base to use.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function sqrt($base)
    {
        if (!static::is($base)) {
            throw new \InvalidArgumentException("The \$base parameters must be int.");
        }

        return sqrt($base);
    }

    //endregion
}
