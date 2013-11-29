<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.4
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

/**
 * Class Str
 *
 * String operations.
 *
 * @package axelitus\Base
 */
class Str
{
    //region Constants

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

    //endregion

    //region Value Testing

    /**
     * Tests if the given value is a string or not.
     *
     * This function is just an alias to the is_string function.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is a string, false otherwise.
     */
    public static function is($value)
    {
        return is_string($value);
    }

    //endregion

    //region Comparing

    /**
     * Compares two strings.
     *
     * @param string $str1            The first string.
     * @param string $str2            The second string.
     * @param bool   $caseInsensitive Whether the comparison should be case sensitive or case insensitive.
     *
     * @return int Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they are equal.
     */
    public static function compare($str1, $str2, $caseInsensitive = false)
    {
        return ($caseInsensitive) ? strcasecmp($str1, $str2) : strcmp($str1, $str2);
    }

    /**
     * Determines if two strings are equal.
     *
     * @param string $str1            The first string.
     * @param string $str2            The second string.
     * @param bool   $caseInsensitive Whether the comparison should be case sensitive or case insensitive.
     *
     * @return bool Returns true if both strings are equal, false otherwise.
     */
    public static function equals($str1, $str2, $caseInsensitive = false)
    {
        return (static::compare($str1, $str2, $caseInsensitive) == 0);
    }

    //endregion

    //region Length

    /**
     * Gets the length of the given string.
     *
     * Uses the multibyte function if available with the given encoding $encoding.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string.
     * @param string $encoding The encoding of the input string for multibyte functions.
     *
     * @return int Returns the length of the string.
     */
    public static function length($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strlen') ? mb_strlen($input, $encoding) : strlen($input);
    }

    //endregion
}
