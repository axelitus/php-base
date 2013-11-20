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
}
