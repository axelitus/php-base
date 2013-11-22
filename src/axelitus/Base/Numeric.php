<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.3
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
     * Determines if two given values are equal.
     *
     * The given values $a and $b must be of type numeric. For the sake of this implementation
     * there is no distinction between the == equal operator and the identical === operator.
     *
     * @param numeric|PrimitiveNumeric $a The first of the values to compare.
     * @param numeric|PrimitiveNumeric $b The second of the values to compare.
     *
     * @throws \InvalidArgumentException
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     */
    final static function areEqual($a, $b)
    {
        try {
            $a = static::native($a);
            $b = static::native($b);
        } catch (\InvalidArgumentException $ex) {
            throw new \InvalidArgumentException("The \$a and \$b parameters must be numeric or instances derived from PrimitiveNumeric.");
        }

        return $a == $b;
    }
}
