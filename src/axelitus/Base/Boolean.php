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

use axelitus\Base\Primitives\Boolean\PrimitiveBoolean;

/**
 * Class Boolean
 *
 * Defines a Boolean.
 *
 * @package axelitus\Base
 */
class Boolean extends PrimitiveBoolean
{
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
    public function native($value) {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a boolean or instance derived from PrimitiveBoolean.");
        }

        return (is_object($value) and ($value instanceof PrimitiveBoolean)) ? $value->value() : $value;
    }
}
