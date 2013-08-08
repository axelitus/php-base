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

namespace axelitus\Base;

use axelitus\Base\Primitives\String\PrimitiveString;

/**
 * Class String
 *
 * @package axelitus\Base
 */
class String extends PrimitiveString
{
    /**
     * Determines if two given values are equal.
     *
     * The given values $a and $b must be of type string. For the sake of this implementation
     * there is no distinction between the == equal operator and the identical === operator.
     *
     * @param int|float|PrimitiveString $a The first of the values to compare.
     * @param int|float|PrimitiveString $b The second of the values to compare.
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     * @throws \InvalidArgumentException
     */
    final static function isEqual($a, $b)
    {
        if (!static::is($a) or !static::is($b)) {
            throw new \InvalidArgumentException("Both parameters \$a and \$b must be strings.");
        }

        $val_a = (is_object($a)) ? $a->value() : $a;
        $val_b = (is_object($b)) ? $b->value() : $b;

        return (strcmp($val_a, $val_b) === 0);
    }

    /**
     * Gets the length of the given string.
     *
     * Uses the multibyte function if available with the given encoding $encoding.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param string|PrimitiveString $input The input string.
     * @param \axelitus\Base\Primitives\String\PrimitiveString|string $encoding The encoding of the input string for multibyte functions.
     * @throws \InvalidArgumentException
     * @return int Returns the length of the string.
     */
    public static function length($input, $encoding = self::DEFAULT_ENCODING)
    {
        if (!static::is($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be string.");
        }

        $val_input = (is_object($input)) ? $input->value() : $input;

        return function_exists('mb_strlen') ? mb_strlen($val_input, $encoding) : strlen($val_input);
    }

    /**
     * Returns the portion of string specified by the $start and $length parameters.
     *
     * USes the multibyte function if available with the given encoding $encoding and falls back to substr.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param string|PrimitiveString $input The input string.
     * @param string|PrimitiveString $start The start index from where to begin extracting.
     * @param int $length The length of the extracted substring.
     * @param string $encoding The encoding of the $input string for multibyte functions.
     * @throws \InvalidArgumentException
     * @return string Returns the extracted substring or false on failure.
     */
    public static function sub($input, $start, $length = null, $encoding = self::DEFAULT_ENCODING)
    {
        if (!static::is($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be string.");
        }

        $val_input = (is_object($input)) ? $input->value() : $input;

        // sub input functions don't parse null correctly
        $length = is_null($length) ? (function_exists('mb_substr') ? mb_strlen($val_input, $encoding) : strlen(
                $val_input
            )) - $start : $length;

        return function_exists('mb_substr') ? mb_substr($val_input, $start, $length, $encoding) : substr(
            $val_input,
            $start,
            $length
        );
    }


    /**
     * Verifies if a string begins with a substring.
     *
     * Uses the multibyte function if available with the given encoding $encoding. The comparison is case-sensitive by default.
     *
     * @param string $input The input string to compare to.
     * @param string $search The substring to compare the beginning to.
     * @param bool $case_sensitive Whether the comparison is case-sensitive.
     * @param string $encoding The encoding of the input string.
     * @return bool Returns true if the $input string begins with the given $search string.
     * @throws \InvalidArgumentException
     */
    public static function beginsWith($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!static::is($input) or !static::is($search)) {
            throw new \InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        $val_input = (is_object($input)) ? $input->value() : $input;
        $val_search = (is_object($search)) ? $search->value() : $search;

        $substr = static::sub($val_input, 0, static::length($val_search), $encoding);

        return !(($case_sensitive) ? strcmp($substr, $val_search) : strcasecmp($substr, $val_search));
    }

    /**
     * Verifies if a string ends with a substring.
     *
     * Uses the multibyte function if available with the given encoding $encoding. The comparison is case-sensitive by default.
     *
     * @param string $input The input string to compare to.
     * @param string $search The substring to compare the ending to.
     * @param bool $case_sensitive Whether the comparison is case-sensitive.
     * @param string $encoding The encoding of the input string.
     * @return bool Returns true if the $input string ends with the given $search string.
     * @throws \InvalidArgumentException
     */
    public static function endsWith($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!static::is($input) or !static::is($search)) {
            throw new \InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        $val_input = (is_object($input)) ? $input->value() : $input;
        $val_search = (is_object($search)) ? $search->value() : $search;

        if (($length = static::length($val_search, $encoding)) == 0) {
            return true;
        }

        $substr = static::sub($val_input, -$length, $length, $encoding);

        return !(($case_sensitive) ? strcmp($substr, $val_search) : strcasecmp($substr, $val_search));
    }
}
