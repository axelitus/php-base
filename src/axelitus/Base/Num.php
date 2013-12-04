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

namespace axelitus\Base;

/**
 * Class Numeric
 *
 * Numeric operations.
 *
 * @package axelitus\Base
 */
class Num
{
    //region Value Testing

    public static function is($value)
    {
        return (Int::is($value) || Float::is($value));
    }

    public static function extIs($value)
    {
        return (Int::extIs($value) || Float::extIs($value));
    }

    //endregion

    //region Comparing

    public static function compare($num1, $num2)
    {
        if (!static::is($num1) || !static::is($num2)) {
            throw new \InvalidArgumentException("The \$num1 and \$num2 parameters must be numeric.");
        }

        return ($num1 - $num2);
    }

    public static function equals($num1, $num2)
    {
        return (static::compare($num1, $num2) == 0);
    }

    /**
     * Tests if a number is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param int|float $value          The value to test in range.
     * @param int|float $lower          The range's lower limit.
     * @param int|float $upper          The range's upper limit.
     * @param bool      $lowerExclusive Whether the lower bound is exclusive.
     * @param bool      $upperExclusive Whether the upper bound is exclusive.
     *
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @throws \InvalidArgumentException
     */
    public static function inRange($value, $lower, $upper, $lowerExclusive = false, $upperExclusive = false)
    {
        if (!static::is($value) || !static::is($lower) || !static::is($upper)) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be numeric.");
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
     * Tests if a number is inside a range.
     *
     * It's an alias for Num::inRange($value, $lower, $upper, false, false)
     *
     * @param int|float $value The value to test in range.
     * @param int|float $lower The range's lower limit.
     * @param int|float $upper The range's upper limit.
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
     * It's an alias for Num::inRange($value, $lower, $upper, true, true)
     *
     * @param int|float $value The value to test in range.
     * @param int|float $lower The range's lower limit.
     * @param int|float $upper The range's upper limit.
     *
     * @return bool Whether the value is between the given range.
     * @see Num::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }

    //endregion
}
