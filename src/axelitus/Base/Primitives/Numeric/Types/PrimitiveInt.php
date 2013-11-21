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

namespace axelitus\Base\Primitives\Numeric\Types;

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class PrimitiveInt
 *
 * Defines the int primitives.
 *
 * @package axelitus\Base\Primitives\Numeric\Types
 */
abstract class PrimitiveInt extends PrimitiveNumeric
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
        return parent::validateValue($value) and $this->is($value);
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
        return (static::isSimple($var) and (is_int($var) or (strval(intval($var)) === strval($var)))) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveInt'
        );
    }

    /**
     * Gets the native integer of a given value. If the given value is of type PrimitiveInt,
     * the object's value is returned, if it's an integer, the integer is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveInt $value The value to get the native integer value from.
     *
     * @throws \InvalidArgumentException
     * @return int The native integer value.
     */
    public static function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be an integer or instance derived from PrimitiveInt.");
        }

        return (is_object($value) and ($value instanceof PrimitiveInt)) ? $value->value() : $value;
    }
}
