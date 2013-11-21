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

namespace axelitus\Base\Primitives\Boolean;

use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveBoolean
 *
 * Defines the boolean primitives.
 *
 * @package axelitus\Base\Primitives\Boolean
 */
abstract class PrimitiveBoolean extends Primitive
{
    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveBoolean');
    }

    /**
     * Determines if $var is of the primitive type numeric (int or float).
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is of the type numeric, false otherwise.
     */
    public static function is($var)
    {
        return (static::isSimple($var) and (is_bool($var) or $var === 0 or $var === 1)) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveBoolean'
        );
    }

    /**
     * Gets the native boolean of a given value. If the given value is of type PrimitiveBoolean,
     * the object's value is returned, if it's a boolean, the boolean is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveBoolean $value The value to get the native boolean value from.
     *
     * @throws \InvalidArgumentException
     * @return bool The native boolean value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a boolean or instance derived from PrimitiveBoolean.");
        }

        return (is_object($value) and ($value instanceof PrimitiveBoolean)) ? $value->value() : $value;
    }
}
