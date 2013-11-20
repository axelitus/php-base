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

use axelitus\Base\Primitives\Numeric\Types\PrimitiveInt;

/**
 * Class Int
 *
 * Defines an Int.
 *
 * @package axelitus\Base
 */
class Int extends PrimitiveInt
{
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
        if (!Int::is($min) or !Int::is($max)) {
            throw new \InvalidArgumentException("The \$min and \$max values must be of type integers.");
        }

        if (!is_null($seed) and Int::is($seed)) {
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
        if (!static::is($value) or !static::is($lower) or !static::is($upper)) {
            throw new \InvalidArgumentException("The \$value, \$lower and \$upper parameters must be integers.");
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
     * @return bool Whether the value is in the given range given the bounds configurations.
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
     * @return bool Whether the value is in the given range given the bounds configurations.
     * @see Int::inRange
     */
    public static function between($value, $lower, $upper)
    {
        return static::inRange($value, $lower, $upper, true, true);
    }
}
