<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.2
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

use axelitus\Base\Primitives\Numeric\Types\PrimitiveFloat;
use axelitus\Base\Primitives\Numeric\Types\PrimitiveInt;

/**
 * Class Float
 *
 * Defines a float.
 *
 * @package axelitus\Base
 */
class Float extends PrimitiveFloat
{
    /**
     * Generates a random float number between min and max.
     *
     * @param float|PrimitiveFloat  $min   Lower bound (inclusive)
     * @param float|PrimitiveFloat  $max   Upper bound (non-inclusive)
     * @param null|int|PrimitiveInt $round Decimal places to round the number to (or null for no rounding)
     * @param null|int|PrimitiveInt $seed  Random generator seed
     *
     * @return float|false A random float value between min (or 0) and max (or 1, exclusive), or FALSE if max
     *               is less than min.
     * @throws \InvalidArgumentException
     */
    public static function random($min = 0.0, $max = 1.0, $round = null, $seed = null)
    {
        try {
            $min = static::native($min);
            $max = static::native($max);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$min and \$max parameters must be float or instances derived from PrimitiveFloat.");
        }

        try {
            $round = (is_null($round)) ? $round : PrimitiveInt::native($round);
            $seed = (is_null($seed)) ? $seed : PrimitiveInt::native($seed);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$round and \$seed parameters must be integers or instances derived from PrimitiveInt.");
        }

        if ($min >= $max) {
            trigger_error("The \$min value cannot be greater or equal than the \$max value.", E_WARNING);
            return false;
        }

        if (!is_null($seed) and Int::is($seed)) {
            mt_srand($seed);
        }

        // Ensure the max is not inclusive
        $rand = $min + (((mt_rand() - 1) / mt_getrandmax()) * abs($max - $min));

        if ($round > 0) {
            $rand = round($rand, $round);
        }

        // unseed (random reseed) random generator
        mt_srand();

        return $rand;
    }

    /**
     * Tests if a float is in a range.
     *
     * Tests if a value is in a range. The function will correct the limits if inverted. The tested range
     * can be set to have its lower and upper limits inclusive (bounds closed) or exclusive (bounds opened) using
     * the $lowerExclusive and $upperExclusive parameters (all possible variations: ]a,b[ -or- ]a,b] -or- [a,b[
     * -or- [a,b]).
     *
     * @param float|PrimitiveFloat $value          The value to test in range.
     * @param float|PrimitiveFloat $lower          The range's lower limit.
     * @param float|PrimitiveFloat $upper          The range's upper limit.
     * @param bool                 $lowerExclusive Whether the lower bound is exclusive.
     * @param bool                 $upperExclusive Whether the upper bound is exclusive.
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
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be float or instances derived from PrimitiveFloat.");
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
     * @param float|PrimitiveFloat $value The value to test in range.
     * @param float|PrimitiveFloat $lower The range's lower limit.
     * @param float|PrimitiveFloat $upper The range's upper limit.
     *
     * @throws \InvalidArgumentException
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @see Float::inRange
     */
    public static function inside($value, $lower, $upper)
    {
        try {
            $value = static::native($value);
            $lower = static::native($lower);
            $upper = static::native($upper);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be float or instances derived from PrimitiveFloat.");
        }

        return static::inRange($value, $lower, $upper, false, false);
    }

    /**
     * Tests if a float is between a range.
     *
     * It's an alias for Float::inRange($value, $lower, $upper, true, true)
     *
     * @param float|PrimitiveFloat $value The value to test in range.
     * @param float|PrimitiveFloat $lower The range's lower limit.
     * @param float|PrimitiveFloat $upper The range's upper limit.
     *
     * @throws \InvalidArgumentException
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @see Float::inRange
     */
    public static function between($value, $lower, $upper)
    {
        try {
            $value = static::native($value);
            $lower = static::native($lower);
            $upper = static::native($upper);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be float or instances derived from PrimitiveFloat.");
        }

        return static::inRange($value, $lower, $upper, true, true);
    }
}
