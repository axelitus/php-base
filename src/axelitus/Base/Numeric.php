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

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class Numeric
 *
 * Defines a Numeric.
 *
 * @package axelitus\Base
 */
class Numeric extends PrimitiveNumeric
{
    /**
     * Gets the native numeric of a given value. If the given value is of type PrimitiveNumeric,
     * the object's value is returned, if it's a numeric, the numeric is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveNumeric $value The value to get the native numeric value from.
     *
     * @throws \InvalidArgumentException
     * @return int|float The native numeric value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a numeric or instance derived from PrimitiveNumeric.");
        }

        return (is_object($value) and ($value instanceof PrimitiveNumeric)) ? $value->value() : $value;
    }

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
