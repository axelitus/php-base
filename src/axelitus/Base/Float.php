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
 * Class Float
 *
 * Float operations.
 *
 * @package axelitus\Base
 */
class Float
{
    //region Value Testing

    public static function is($value)
    {
        return is_float($value);
    }

    public static function extIs($value)
    {
        // TODO: fix known issue when $value is a float with decimal .0
        return (static::is($value) || (is_string($value) && (strval(floatval($value)) === strval($value))));
    }

    //endregion

    //region Comparing

    public static function compare($float1, $float2)
    {
        if (!static::is($float1) || !static::is($float2)) {
            throw new \InvalidArgumentException("The \$float1 and \$float2 parameters must be of type float.");
        }

        return ($float1 - $float2);
    }

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
}
