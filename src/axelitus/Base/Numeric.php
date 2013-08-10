<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class Numeric
 *
 * @package axelitus\Base
 */
class Numeric extends PrimitiveNumeric
{
    /**
     * Determines if two given values are equal.
     *
     * The given values $a and $b must be of type numeric. For the sake of this implementation
     * there is no distinction between the == equal operator and the identical === operator.
     *
     * @param int|float|PrimitiveNumeric $a The first of the values to compare.
     * @param int|float|PrimitiveNumeric $b The second of the values to compare.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     */
    final static function areEqual($a, $b)
    {
        if (!static::is($a) or !static::is($b)) {
            throw new \InvalidArgumentException("Both parameters \$a and \$b must be numeric.");
        }

        $val_a = (is_object($a)) ? $a->value() : $a;
        $val_b = (is_object($b)) ? $b->value() : $b;

        return $val_a == $val_b;
    }
}
