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

namespace axelitus\Base\Primitives\Numeric\Types;

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class PrimitiveFloat
 *
 * Defines the float primitives.
 *
 * @package axelitus\Base\Primitives\Numeric\Types
 */
abstract class PrimitiveFloat extends PrimitiveNumeric
{
    /**
     * Validates the given primitive value.
     *
     * This function is automatically called from the parent class automatically.
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateValue($value)
    {
        return parent::validateValue($value) and $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveFloat');
    }

    /**
     * Determines if the given value is of this primitive type.
     *
     * @param mixed $var
     *
     * @return bool
     */
    public static function is($var)
    {
        return (static::isSimple($var) and (is_float($var) or (strval(floatval($var)) === strval($var)))) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveFloat'
        );
    }

    /**
     * Gets the native float of a given value. If the given value is of type PrimitiveFloat,
     * the object's value is returned, if it's a float, the float is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveFloat $value The value to get the native float value from.
     *
     * @throws \InvalidArgumentException
     * @return float The native float value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a float or instance derived from PrimitiveFloat.");
        }

        return (is_object($value) and ($value instanceof PrimitiveFloat)) ? $value->value() : $value;
    }
}
