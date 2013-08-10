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
 * Class PrimitiveFloat
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
        return (static::isSimple($var) and (is_float($var) or (strval(floatval($var)) === strval($var)))) or is_a(
            $var,
            __NAMESPACE__ . '\PrimitiveFloat'
        );
    }
}
