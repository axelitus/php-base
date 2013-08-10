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

namespace axelitus\Base\Primitives\String;

use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveString
 *
 * @package axelitus\Base\Primitives\String
 */
abstract class PrimitiveString extends Primitive
{
    /**
     * @type string DEFAULT_ENCODING The default encoding to use with the functions that require it.
     * @link http://www.php.net/manual/en/mbstring.supported-encodings.php
     */
    const DEFAULT_ENCODING = 'UTF-8';

    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value);
    }

    /**
     * Determines if $var is of the primitive type string.
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is of the type string, false otherwise.
     */
    public static function is($var)
    {
        return is_string($var) or is_a($var, __NAMESPACE__ . '\PrimitiveString');
    }
}
