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
 * Class BigFloat
 *
 * Float operations for big numbers.
 *
 * The function in this class are strict-typed (only accept float values).
 * If you want to accept both int and float use the {@link Num} class instead.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BigFloat
{
    // region: Value Testing

    /**
     * Tests if the given value is a float (even if it's big).
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a float (big), false otherwise.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function is($value)
    {
        return (is_float($value) || (is_numeric($value) && !is_int($value) && Str::contains($value, '.')));
    }

    /**
     * Tests if the given value is even.
     *
     * @param float|string $value The value to test.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if the given value is even, false otherwise.
     */
    public static function isEven($value, $scale = null)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be of type float (or string representing a big float)."
            );
        }

        return static::equals(static::mod($value, 2.0, $scale), 0.0, $scale);
    }

    /**
     * Tests if the given value is odd.
     *
     * @param float|string $value The value to test.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if the given value is odd, false otherwise.
     */
    public static function isOdd($value, $scale = null)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be of type float (or string representing a big float)."
            );
        }

        return static::equals(static::abs(static::mod($value, 2.0, $scale)), 1.0, $scale);
    }

    // endregion

    // region: Conversion

    /**
     * Gets the integer value of the given value.
     *
     * @param float|string $value The value to get the integer value from.
     *
     * @return int|string The integer value of the given value.
     * @throws \InvalidArgumentException
     */
    public static function toInt($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be of type float (or string representing a big float)."
            );
        }

        return BigNum::toInt($value);
    }

    // endregion

    // region: Comparing

    /**
     * Compares two int values.
     *
     * The returning value contains the actual value difference.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string Returns <0 if $float1<$float2, =0 if $float1 == $float2, >0 if $float1>$float2
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function compare($float1, $float2, $scale = null)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException(
                "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($float1) && is_float($float2)) {
            return ($float1 - $float2);
        } elseif (function_exists('bcsub')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcsub($float1, $float2)
                : bcsub($float1, $float2, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Tests if two given int values are equal.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return bool Returns true if $float1 == $float2, false otherwise.
     */
    public static function equals($float1, $float2, $scale = null)
    {
        return (static::compare($float1, $float2, $scale) == '0.0');
    }

    /**
     * Tests if an integer is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param float|string $value          The value to test in range.
     * @param float|string $lower          The range's lower limit.
     * @param float|string $upper          The range's upper limit.
     * @param bool         $lowerExclusive Whether the lower bound is exclusive.
     * @param bool         $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException(
                "The \$value, \$lower and \$upper parameters must be of type float"
                . " (or string representing a big float)."
            );
        }

        $lowerLimit = min($lower, $upper);
        if (!(($lowerExclusive) ? $lowerLimit < $value : $lowerLimit <= $value)) {
            return false;
        }

        $upperLimit = max($lower, $upper);
        if (!(($upperExclusive) ? $upperLimit > $value : $upperLimit >= $value)) {
            return false;
        }

        return true;
    }

    /**
     * Tests if an integer is inside a range.
     *
     * It's an alias for BigFloat::inRange($value, $lower, $upper, false, false)
     *
     * @param float|string $value The value to test in range.
     * @param float|string $lower The range's lower limit.
     * @param float|string $upper The range's upper limit.
     *
     * @return bool Whether the value is inside the given range.
     * @see BigFloat::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if an integer is between a range.
     *
     * It's an alias for BigFloat::inRange($value, $lower, $upper, true, true)
     *
     * @param float|string $value The value to test in range.
     * @param float|string $lower The range's lower limit.
     * @param float|string $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see BigFloat::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    // endregion

    // region: Basic numeric operations

    /**
     * Gets the absolute value of the given float.
     *
     * @param int|string $float The number to get the absolute value of.
     *
     * @return int|string Returns the absolute value of the given float.
     */
    public static function abs($float)
    {
        if (!static::is($float)) {
            throw new \InvalidArgumentException(
                "The \$float parameter must be of type float (or string representing a big float)."
            );
        }

        if (Float::is($float)) {
            return Float::abs($float);
        } else {
            return Str::replace($float, '-', '');
        }
    }

    /**
     * Adds a number to another number.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function add($float1, $float2, $scale = null)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException(
                "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($float1) && is_float($float2)) {
            return ($float1 + $float2);
        } elseif (function_exists('bcadd')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcadd($float1, $float2)
                : bcadd($float1, $float2, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Subtracts a number from another number.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sub($float1, $float2, $scale = null)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException(
                "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($float1) && is_float($float2)) {
            return ($float1 - $float2);
        } elseif (function_exists('bcsub')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcsub($float1, $float2)
                : bcsub($float1, $float2, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Multiplies a number by another number.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mul($float1, $float2, $scale = null)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException(
                "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($float1) && is_float($float2)) {
            return ($float1 * $float2);
        } elseif (function_exists('bcmul')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcmul($float1, $float2)
                : bcmul($float1, $float2, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Divides a number by another number.
     *
     * @param float|string $float1 The left operand.
     * @param float|string $float2 The right operand.
     * @param null|int     $scale  The scale to use for BCMath functions.
     *                             If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function div($float1, $float2, $scale = null)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException(
                "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
            );
        }

        if ($float2 == '0') {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$float2 parameter cannot be zero.");
        }

        if (is_float($float1) && is_float($float2)) {
            return ($float1 / $float2);
        } elseif (function_exists('bcdiv')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcdiv($float1, $float2)
                : bcdiv($float1, $float2, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Raises a number to the power of another number.
     *
     * @param float|string $base     The base number.
     * @param float|string $exponent The power exponent.
     * @param null|int     $scale    The scale to use for BCMath functions.
     *                               If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function pow($base, $exponent, $scale = null)
    {
        if (!static::is($base) || !static::is($exponent)) {
            throw new \InvalidArgumentException(
                "The \$base and \$exponent parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($base) && is_float($exponent)) {
            return pow($base, $exponent);
        } elseif (function_exists('bcpow')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcpow($base, $exponent)
                : bcpow($base, $exponent, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the remainder of a number divided by another number.
     *
     * @param float|string $base    The left operand.
     * @param float|string $modulus The right operand.
     * @param null|int     $scale   The scale to use for BCMath functions.
     *                              If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mod($base, $modulus, $scale = null)
    {
        if (!static::is($base) || !static::is($modulus)) {
            throw new \InvalidArgumentException(
                "The \$base and \$modulus parameters must be of type float (or string representing a big float)."
            );
        }

        if ($modulus == '0') {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$modulus parameter cannot be zero.");
        }

        if (is_float($base) && is_float($modulus)) {
            return fmod($base, $modulus);
        } elseif (function_exists('bcdiv')) {
            // We cannot use bcmod because it only returns the int remainder
            $times = BigNum::toFloat(((is_null($scale))
                ? static::toInt(BigNum::toFloat(bcdiv($base, $modulus)))
                : static::toInt(BigNum::toFloat(bcdiv($base, $modulus, $scale)))
            ));

            return BigNum::toFloat(static::sub($base, static::mul($times, $modulus, $scale), $scale));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the square root of a number.
     *
     * @param float|string $base  The base to use.
     * @param null|int     $scale The scale to use for BCMath functions.
     *                            If null is given the value set by {@link bcscale()} is used.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sqrt($base, $scale = null)
    {
        if (!static::is($base)) {
            throw new \InvalidArgumentException(
                "The \$base parameters must be of type float (or string representing a big float)."
            );
        }

        if (is_float($base)) {
            return sqrt($base);
        } elseif (function_exists('bcsqrt')) {
            return BigNum::toFloat(((is_null($scale))
                ? bcsqrt($base)
                : bcsqrt($base, $scale)));
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    // endregion
}
