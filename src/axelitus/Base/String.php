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
     * Gets the length of the given string.
     *
     * Uses the multibyte function if available with the given encoding $encoding.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param $input The input string.
     * @param $encoding The encoding of the input string for multibyte functions.
     * @return int Returns the length of the string.
     */
    public static function length($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strlen') ? mb_strlen($input, $encoding) : strlen($input);
    }

    /**
     * Returns the portion of string specified by the $start and $length parameters.
     *
     * USes the multibyte function if available with the given encoding $encoding and falls back to substr.
     *
     * @author  FuelPHP (http://fuelphp.com)
     * @param $input The input string.
     * @param $start The start index from where to begin extracting.
     * @param int $length The length of the extracted substring.
     * @param $encoding The encoding of the $input string for multibyte functions.
     * @return string Returns the extracted substring or false on failure.
     */
    public static function sub($input, $start, $length = null, $encoding = self::DEFAULT_ENCODING)
    {
        // sub input functions don't parse null correctly
        $length = is_null($length) ? (function_exists('mb_substr') ? mb_strlen($input, $encoding) : strlen(
                $input
            )) - $start : $length;

        return function_exists('mb_substr') ? mb_substr($input, $start, $length, $encoding) : substr(
            $input,
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

        $substr = static::sub($input, 0, static::length($search), $encoding);

        return !(($case_sensitive) ? strcmp($substr, $search) : strcasecmp($substr, $search));
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

        if (($length = static::length($search, $encoding)) == 0) {
            return true;
        }

        $substr = static::sub($input, -$length, $length, $encoding);

        return !(($case_sensitive) ? strcmp($substr, $search) : strcasecmp($substr, $search));
    }
}
