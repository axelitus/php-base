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
 * Class BigInt
 *
 * Int operations for big numbers.
 *
 * The function in this class are strict-typed (only accept int values).
 * If you want to accept both int and float use the {@link Num} class instead.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BigInt
{
    // region: Value Testing

    /**
     * Tests if the given value is an int (even if it's big).
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is an int (big), false otherwise.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function is($value)
    {
        return (is_int($value) || (is_numeric($value) && !is_float($value) && !Str::contains($value, '.')));
    }

    /**
     * Tests if the given value is even.
     *
     * @param int|string $value The value to test.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if the given value is even, false otherwise.
     */
    public static function isEven($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be of type int (or string representing a big int)."
            );
        }

        return static::equals(static::mod($value, 2), 0);
    }

    /**
     * Tests if the given value is odd.
     *
     * @param int|string $value The value to test.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if the given value is odd, false otherwise.
     */
    public static function isOdd($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException(
                "The \$value parameter must be of type int (or string representing a big int)."
            );
        }

        return static::equals(static::abs(static::mod($value, 2)), 1);
    }

    // endregion

    // region: Comparing

    /**
     * Compares two int values.
     *
     * The returning value contains the actual value difference.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return int|string Returns <0 if $int1<$int2, =0 if $int1 == $int2, >0 if $int1>$int2
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function compare($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException(
                "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($int1) && is_int($int2)) {
            return ($int1 - $int2);
        } elseif (function_exists('bcsub')) {
            return bcsub($int1, $int2);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Tests if two given int values are equal.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return bool Returns true if $int1 == $int2, false otherwise.
     */
    public static function equals($int1, $int2)
    {
        return (static::compare($int1, $int2) == '0');
    }

    /**
     * Tests if an integer is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param int|string $value          The value to test in range.
     * @param int|string $lower          The range's lower limit.
     * @param int|string $upper          The range's upper limit.
     * @param bool       $lowerExclusive Whether the lower bound is exclusive.
     * @param bool       $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException(
                "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
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
     * It's an alias for BigInt::inRange($value, $lower, $upper, false, false)
     *
     * @param int|string $value The value to test in range.
     * @param int|string $lower The range's lower limit.
     * @param int|string $upper The range's upper limit.
     *
     * @return bool Whether the value is inside the given range.
     * @see BigInt::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if an integer is between a range.
     *
     * It's an alias for BigInt::inRange($value, $lower, $upper, true, true)
     *
     * @param int|string $value The value to test in range.
     * @param int|string $lower The range's lower limit.
     * @param int|string $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see BigInt::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    // endregion

    // region: Basic numeric operations

    /**
     * Gets the absolute value of the given integer.
     *
     * @param int|string $int The number to get the absolute value of.
     *
     * @return int|string Returns the absolute value of the given integer.
     */
    public static function abs($int)
    {
        if (!static::is($int)) {
            throw new \InvalidArgumentException(
                "The \$int parameter must be of type int (or string representing a big int)."
            );
        }

        if (Int::is($int)) {
            return Int::abs($int);
        } else {
            return Str::replace($int, '-', '');
        }
    }

    /**
     * Adds a number to another number.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return int|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function add($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException(
                "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($int1) && is_int($int2)) {
            return ($int1 + $int2);
        } elseif (function_exists('bcadd')) {
            return bcadd($int1, $int2);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Subtracts a number from another number.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return int|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sub($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException(
                "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($int1) && is_int($int2)) {
            return ($int1 - $int2);
        } elseif (function_exists('bcsub')) {
            return bcsub($int1, $int2);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Multiplies a number by another number.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return int|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mul($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException(
                "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($int1) && is_int($int2)) {
            return ($int1 * $int2);
        } elseif (function_exists('bcmul')) {
            return bcmul($int1, $int2);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Divides a number by another number.
     *
     * @param int|string $int1 The left operand.
     * @param int|string $int2 The right operand.
     *
     * @return int|float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function div($int1, $int2)
    {
        if (!static::is($int1) || !static::is($int2)) {
            throw new \InvalidArgumentException(
                "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
            );
        }

        if ($int2 == '0') {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$int2 parameter cannot be zero.");
        }

        if (is_int($int1) && is_int($int2)) {
            return ($int1 / $int2);
        } elseif (function_exists('bcdiv')) {
            return bcdiv($int1, $int2);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Raises a number to the power of another number.
     *
     * @param int|string $base     The base number.
     * @param int|string $exponent The power exponent.
     *
     * @return int|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function pow($base, $exponent)
    {
        if (!static::is($base) || !static::is($exponent)) {
            throw new \InvalidArgumentException(
                "The \$base and \$exponent parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($base) && is_int($exponent)) {
            return pow($base, $exponent);
        } elseif (function_exists('bcpow')) {
            return bcpow($base, $exponent);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the remainder of a number divided by another number.
     *
     * @param int|string $base    The left operand.
     * @param int|string $modulus The right operand.
     *
     * @return int|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function mod($base, $modulus)
    {
        if (!static::is($base) || !static::is($modulus)) {
            throw new \InvalidArgumentException(
                "The \$base and \$modulus parameters must be of type int (or string representing a big int)."
            );
        }

        if ($modulus == '0') {
            throw new \InvalidArgumentException("Cannot divide by zero. The \$modulus parameter cannot be zero.");
        }

        if (is_int($base) && is_int($modulus)) {
            return ($base % $modulus);
        } elseif (function_exists('bcmod')) {
            return bcmod($base, $modulus);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    /**
     * Gets the square root of a number.
     *
     * @param int|string $base The base to use.
     *
     * @return float|string The result of the operation.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function sqrt($base)
    {
        if (!static::is($base)) {
            throw new \InvalidArgumentException(
                "The \$base parameters must be of type int (or string representing a big int)."
            );
        }

        if (is_int($base)) {
            return sqrt($base);
        } elseif (function_exists('bcsqrt')) {
            return bcsqrt($base);
        }

        throw new \RuntimeException("The BCMath library is not available."); // @codeCoverageIgnore
    }

    // endregion
}
