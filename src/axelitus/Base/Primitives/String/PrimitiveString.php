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

namespace axelitus\Base\Primitives\String;

use axelitus\Base\Primitives\Primitive;

/**
 * Class PrimitiveString
 *
 * Defines the string primitives.
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
     * @type string  A string containing all alpha characters
     */
    const ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @type string  A string containing all numbers
     */
    const NUM = '0123456789';

    /**
     * @type string  A string containing all alphanumeric characters
     */
    const ALNUM = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @type string  A string containing all hexadecimal characters
     */
    const HEXDEC = '0123456789abcdef';

    /**
     * @type string  A string containing distinct characters
     */
    const DISTINCT = '2345679ACDEFHJKLMNPRSTUVWXYZ';

    /**
     * @type string  A string containing ascii printable characters according to Wikipedia:
     * http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
     * Be careful, the ' char is escaped so it looks like \ is twice, but it is not.
     */
    const ASCII_PRINTABLE = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';

    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    protected function validateValue($value)
    {
        return $this->is($value) and !is_a($value, __NAMESPACE__ . '\PrimitiveString');
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

    /**
     * Gets the native string of a given value. If the given value is of type PrimitiveString,
     * the object's value is returned, if it's a string, the string is returned unaltered.
     * If it's something else, an exception is thrown.
     *
     * @param string|PrimitiveString $value The value to get the native string value from.
     *
     * @throws \InvalidArgumentException
     * @return string The native string value.
     */
    public static function native($value)
    {
        if (!static::is($value)) {
            throw new \InvalidArgumentException("The \$value must be a string or instance derived from PrimitiveString.");
        }

        return (is_object($value) and ($value instanceof PrimitiveString)) ? $value->value() : $value;
    }
}
