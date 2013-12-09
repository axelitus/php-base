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
 * Class Float
 *
 * Float operations.
 *
 * The function in this class are strict-typed (only accept float values).
 * If you want to accept both int and float use the {@link Num} class instead.
 *
 * @package axelitus\Base
 */
class Float
{
    //region Value Testing

    /**
     * Tests if the given value is a float (type test).
     *
     * This function uses the is_float() function to test.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a float, false otherwise.
     */
    public static function is($value)
    {
        return is_float($value);
    }

    /**
     * Tests if the given value is a float or a string representation of a float.
     *
     * This function is strict, so it does not match integers of the form X,
     * though it matches numbers of the form X.0 use @see Num::is to match either a float or an int.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the given value is a float or a representation of a float, false otherwise.
     */
    public static function extIs($value)
    {
        return (static::is($value) || (is_numeric($value) && !Int::extIs($value)));
    }

    //endregion

    //region Comparing

    /**
     * Compares two float values.
     *
     * The returning value contains the actual value difference.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return float Returns <0 if $float1<$float2, =0 if $float1 == $float2, >0 if $float1>$float2
     * @throws \InvalidArgumentException
     */
    public static function compare($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be of type float.");
        }

        return ($float1 - $float2);
    }

    /**
     * Tests if two given float values are equal.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return bool Returns true if $float1 == $float2, false otherwise.
     */
    public static function equals($float1, $float2)
    {
        return (static::compare($float1, $float2) == 0);
    }

    /**
     * Tests if a float is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param float $value          The value to test in range.
     * @param float $lower          The range's lower limit.
     * @param float $upper          The range's upper limit.
     * @param bool  $lowerExclusive Whether the lower bound is exclusive.
     * @param bool  $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be of type float.");
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
     * Tests if a float is inside a range.
     *
     * It's an alias for Float::inRange($value, $lower, $upper, false, false)
     *
     * @param float $value The value to test in range.
     * @param float $lower The range's lower limit.
     * @param float $upper The range's upper limit.
     *
     * @return bool Whether the value is inside the given range.
     * @see Float::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if a float is between a range.
     *
     * It's an alias for Float::inRange($value, $lower, $upper, true, true)
     *
     * @param float $value The value to test in range.
     * @param float $lower The range's lower limit.
     * @param float $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see Float::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    //endregion

    //region Random

    /**
     * Generates a random float number between min and max.
     *
     * The function will correct the min and max if inverted.
     *
     * @param float    $min   Lower bound (inclusive)
     * @param float    $max   Upper bound (non-inclusive)
     * @param null|int $round Decimal places to round the number to (or null for no rounding)
     * @param null|int $seed  Random generator seed
     *
     * @return float|false A random float value between min (or 0) and max (or 1, exclusive), or FALSE if max
     *               is less than min.
     * @throws \InvalidArgumentException
     */
    public static function random($min = 0.0, $max = 1.0, $round = null, $seed = null)
    {
        if (!static::is($min) || !static::is($max)) {
            throw new \InvalidArgumentException("The \$min and \$max parameters must be of type float.");
        }

        if ($min > $max) {
            trigger_error("The \$min value cannot be greater than the \$max value.", E_USER_WARNING);
            return false;
        }

        if (!is_null($seed) && Int::is($seed)) {
            mt_srand($seed);
        }

        // Ensure that max is not inclusive
        $rand = $min + (((mt_rand() - 1) / mt_getrandmax()) * abs($max - $min));

        if (!is_null($round) && Int::is($round) && $round > 0) {
            $rand = round($rand, $round);
        }

        // unseed (random reseed) random generator
        mt_srand();

        return $rand;
    }

    //endregion

    //region Basic numeric operations

    /**
     * Adds a number to another number.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function add($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be float.");
        }

        return ($float1 + $float2);
    }

    /**
     * Subtracts a number from another number.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function sub($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be float.");
        }

        return ($float1 - $float2);
    }

    /**
     * Multiplies a number by another number.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function mul($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be float.");
        }

        return ($float1 * $float2);
    }

    /**
     * Divides a number by another number.
     *
     * @param float $float1 The left operand.
     * @param float $float2 The right operand.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function div($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be float.");
        }

        if ($float2 == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$float2 parameter cannot be zero.");
        }

        return ($float1 / $float2);
    }

    /**
     * Raises a number to the power of another number.
     *
     * @param float $base The base number.
     * @param float $exponent The power exponent.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function pow($base, $exponent)
    {
        if (!static::is($base) || !static::is($exponent)) {
            throw new \InvalidArgumentException("The \$base and \$exponent parameters must be float.");
        }

        return pow($base, $exponent);
    }

    /**
     * Gets the remainder of a number divided by another number.
     *
     * @param float $base The left operand.
     * @param float $modulus The right operand.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function mod($base, $modulus)
    {
        if (!static::is($base) || !static::is($modulus)) {
            throw new \InvalidArgumentException("The \$base and \$modulus parameters must be float.");
        }

        if ($modulus == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$modulus parameter cannot be zero.");
        }

        return fmod($base, $modulus);
    }

    /**
     * Gets the square root of a number.
     *
     * @param float $base The base to use.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     */
    public static function sqrt($base)
    {
        if (!static::is($base)) {
            throw new \InvalidArgumentException("The \$base parameters must be float.");
        }

        return sqrt($base);
    }

    //endregion
}
