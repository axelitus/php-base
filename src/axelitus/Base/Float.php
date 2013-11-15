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
     * @param float|int $min   Lower bound (inclusive)
     * @param float|int $max   Upper bound (non-inclusive)
     * @param int       $round Decimal places to round the number to (or null for no rounding)
     * @param null|int  $seed  Random generator seed
     *
     * @return float A random float value between min (or 0) and max (or 1, exclusive), or FALSE if max
     *               is less than min.
     * @throws \InvalidArgumentException
     */
    public static function random($min = 0, $max = 1, $round = null, $seed = null)
    {
        if (!Float::is($min) or !Float::is($max)) {
            throw new \InvalidArgumentException("The \$min and \$max values must be of type float.");
        }

        if ($min >= $max) {
            trigger_error("The \$min value cannot be greater or equal than the \$max value.");
            return false;
        }

        if (!is_null($seed) and Int::is($seed)) {
            mt_srand($seed);
        }

        // Ensure the max is not inclusive
        $rand = $min + (((mt_rand() - 1) / mt_getrandmax()) * abs($max - $min));

        if (Int::is($round) and $round > 0) {
            $rand = round($rand, $round);
        }

        // unseed (random reseed) random generator
        mt_srand();

        return $rand;
    }
}
