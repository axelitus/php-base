<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base;

/**
 * Class BigNum
 *
 * Numeric operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BigNum
{
    // region: Value Testing

    /**
     * Tests if the given value is a number (or big number represented by a string).
     *
     * This function uses {@link BigInt::is} and {@link BigFloat::is} functions to test.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a number, false otherwise.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function is($value)
    {
        return (BigInt::is($value) || BigFloat::is($value));
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
    public static function int($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be numeric (or string representing a big number)."
            );
        }

        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return (int)$value;
        }

        if (($decimal = Str::pos($value, '.')) !== false) {
            $value = Str::sub($value, 0, (int)$decimal);
        }

        return $value;
    }

    // endregion

    // region: Comparing

    /**
     * Compares two numeric values.
     *
     * The returning value contains the actual value difference.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int Returns <0 if $num1<$num2, =0 if $num1 == $num2, >0 if $num1>$num2
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function compare($num1, $num2, $scale = null)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException(
                "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($num1) && Num::is($num2)) {
            return ($num1 - $num2);
        } elseif (function_exists('bcsub')) {
            return bcsub($num1, $num2, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Tests if two given numeric values are equal.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return bool Returns true if $num1 == $num2, false otherwise.
     */
    public static function equals($num1, $num2, $scale = null)
    {
        return (static::compare($num1, $num2, $scale) == 0);
    }

    /**
     * Tests if a number is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param int|float|string $value          The value to test in range.
     * @param int|float|string $lower          The range's lower limit.
     * @param int|float|string $upper          The range's upper limit.
     * @param bool             $lowerExclusive Whether the lower bound is exclusive.
     * @param bool             $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException(
                "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
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
     * Tests if a number is inside a range.
     *
     * It's an alias for BigNum::inRange($value, $lower, $upper, false, false)
     *
     * @param int|float|string $value The value to test in range.
     * @param int|float|string $lower The range's lower limit.
     * @param int|float|string $upper The range's upper limit.
     *
     * @return bool Whether the value is inside the given range.
     * @see Num::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if a number is between a range.
     *
     * It's an alias for BigNum::inRange($value, $lower, $upper, true, true)
     *
     * @param int|float|string $value The value to test in range.
     * @param int|float|string $lower The range's lower limit.
     * @param int|float|string $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see Num::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    // endregion

    // region: Basic numeric operations

    /**
     * Adds a number to another number.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function add($num1, $num2, $scale = null)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException(
                "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($num1) && Num::is($num2)) {
            return ($num1 + $num2);
        } elseif (function_exists('bcadd')) {
            return bcadd($num1, $num2, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Subtracts a number from another number.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sub($num1, $num2, $scale = null)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException(
                "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($num1) && Num::is($num2)) {
            return ($num1 - $num2);
        } elseif (function_exists('bcsub')) {
            return bcsub($num1, $num2, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Multiplies a number by another number.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mul($num1, $num2, $scale = null)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException(
                "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($num1) && Num::is($num2)) {
            return ($num1 * $num2);
        } elseif (function_exists('bcmul')) {
            return bcmul($num1, $num2, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Divides a number by another number.
     *
     * @param int|float|string $num1  The left operand.
     * @param int|float|string $num2  The right operand.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function div($num1, $num2, $scale = null)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException(
                "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
            );
        }

        if ($num2 == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$num2 parameter cannot be zero.");
        }

        if (Num::is($num1) && Num::is($num2)) {
            return ($num1 / $num2);
        } elseif (function_exists('bcdiv')) {
            return bcdiv($num1, $num2, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Raises a number to the power of another number.
     *
     * @param int|float|string $base     The base number.
     * @param int|float|string $exponent The power exponent.
     * @param int              $scale    The scale to use for BCMath functions.
     *                                   If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function pow($base, $exponent, $scale = null)
    {
        if (!static::is($base) || !static::is($exponent)) {
            throw new \InvalidArgumentException(
                "The \$base and \$exponent parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($base) && Num::is($exponent)) {
            return pow($base, $exponent);
        } elseif (function_exists('bcpow')) {
            return bcpow($base, $exponent, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the remainder of a number divided by another number.
     *
     * @param int|float|string $base    The left operand.
     * @param int|float|string $modulus The right operand.
     * @param int              $scale   The scale to use for BCMath functions.
     *                                  If null is given the value set by {@link bcscale()} is used.
     *
     * @return float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mod($base, $modulus, $scale = null)
    {
        if (!static::is($base) || !static::is($modulus)) {
            throw new \InvalidArgumentException(
                "The \$base and \$modulus parameters must be numeric (or string representing a big number)."
            );
        }

        if ($modulus == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$modulus parameter cannot be zero.");
        }

        if (Num::is($base) && Num::is($modulus)) {
            return fmod($base, $modulus);
        } elseif (function_exists('bcdiv')) {
            // We cannot use bcmod because it only returns the int remainder
            $times = static::int(bcdiv($base, $modulus, $scale)) . '.0';

            return static::sub($base, static::mul($times, $modulus, $scale), $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the square root of a number.
     *
     * @param int|float|string $base  The base to use.
     * @param int              $scale The scale to use for BCMath functions.
     *                                If null is given the value set by {@link bcscale()} is used.
     *
     * @return int|float The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sqrt($base, $scale = null)
    {
        if (!static::is($base)) {
            throw new \InvalidArgumentException(
                "The \$base parameters must be numeric (or string representing a big number)."
            );
        }

        if (Num::is($base)) {
            return sqrt($base);
        } elseif (function_exists('bcsqrt')) {
            return bcsqrt($base, $scale);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    // endregion
}
