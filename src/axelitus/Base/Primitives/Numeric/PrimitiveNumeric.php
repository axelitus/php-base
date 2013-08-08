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

namespace axelitus\Base\Primitives\Numeric;

use axelitus\Base\Exceptions\NotImplementedException;
use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveNumeric
 *
 * @package axelitus\Base\Primitives\Numeric
 */
abstract class PrimitiveNumeric extends Primitive
{
    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value);
    }

    /**
     * Determines if $var is of the primitive type numeric (int or float).
     *
     * @param mixed $var The value to be tested.
     * @return bool Returns true if $var is of the type numeric, false otherwise.
     */
    public static function is($var)
    {
        return is_numeric($var) or is_a($var, __NAMESPACE__ . '\PrimitiveNumeric');
    }

    /**
     * Determines if both given values are equal.
     *
     * For this implementation, in this case equal is the same as identical.
     *
     * @param int|float|PrimitiveNumeric $a The first of the values to compare.
     * @param int|float|PrimitiveNumeric $b The second of the values to compare.
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     * @throws \axelitus\Base\Exceptions\NotImplementedException
     */
    public static function isEqual($a, $b)
    {
        throw new NotImplementedException("This method is not yet implemented.");
    }
}
