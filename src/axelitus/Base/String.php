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

use axelitus\Base\Primitives\String\PrimitiveString;

/**
 * Class String
 *
 * Defines a String.
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
     *
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     * @throws \InvalidArgumentException
     */
    final static function areEqual($a, $b)
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
     *
     * @param string|PrimitiveString                                  $input                                                                      The input string.
     * @param \axelitus\Base\Primitives\String\PrimitiveString|string $encoding                                                                   The encoding of the input string for multibyte functions.
     *
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
     *
     * @param string|PrimitiveString $input    The input string.
     * @param string|PrimitiveString $start    The start index from where to begin extracting.
     * @param int                    $length   The length of the extracted substring.
     * @param string                 $encoding The encoding of the $input string for multibyte functions.
     *
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
     * Finds the position of the first occurrence of a substring in a string.
     * The $encoding parameter is used to determine the encoding and thus the
     * proper method to be used.
     *
     * @param string $input             The input string to compare to
     * @param string $search            The substring to compare the ending to
     * @param bool   $case_sensitive    Whether the comparison is case-sensitive
     * @param string $encoding          The encoding of the input string
     *
     * @return int|bool     Returns the numeric position of the first occurrence of the searched string in the input string. If it is not found, it returns false.
     * @throws \InvalidArgumentException
     */
    public static function pos($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) or !is_string($search)) {
            throw new \InvalidArgumentException("Both parameters \$input and \$search must be strings.");
        }

        if ($case_sensitive) {
            return function_exists('mb_strpos')
                ? mb_strpos($input, $search, 0, $encoding)
                : (strpos($input, $search) !== false ? true : false);
        } else {
            return function_exists('mb_stripos')
                ? mb_stripos($input, $search, 0, $encoding)
                : (stripos($input, $search) !== false ? true : false);
        }
    }

    /**
     * Verifies if a string contains a substring. The $encoding parameter is used to determine the
     * encoding and thus the proper method.
     *
     * @param string $input             The input string to compare to
     * @param string $search            The substring to compare the ending to
     * @param bool   $case_sensitive    Whether the comparison is case-sensitive
     * @param string $encoding          The encoding of the input string
     *
     * @return bool     Whether the input string contains the substring
     */
    public static function contains($input, $search, $case_sensitive = true, $encoding = self::DEFAULT_ENCODING)
    {
        return (bool) static::pos($input, $search, $case_sensitive, $encoding);
    }

    /**
     * Verifies if a string begins with a substring.
     *
     * Uses the multibyte function if available with the given encoding $encoding. The comparison is case-sensitive by default.
     *
     * @param string $input          The input string to compare to.
     * @param string $search         The substring to compare the beginning to.
     * @param bool   $case_sensitive Whether the comparison is case-sensitive.
     * @param string $encoding       The encoding of the input string.
     *
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
     * @param string $input          The input string to compare to.
     * @param string $search         The substring to compare the ending to.
     * @param bool   $case_sensitive Whether the comparison is case-sensitive.
     * @param string $encoding       The encoding of the input string.
     *
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

    /**
     * Replaces a substring inside a string.
     *
     * @param string $input             The input string
     * @param string $search            The substring to be replaced
     * @param string $replace           The substring replacement
     * @param bool   $case_sensitive    Whether the comparison should be case sensitive
     * @param string $encoding          The encoding of the input string
     *
     * @return string   The string with the substring replaced
     */
    public static function replace(
        $input,
        $search,
        $replace,
        $case_sensitive = true,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        return function_exists('mb_strlen')
            ? static::_mb_str_replace($search, $replace, $input, $case_sensitive, $encoding, $count)
            : (($case_sensitive) ? (str_replace($search, $replace, $input, $count))
                : (str_ireplace($search, $replace, $input, $count)));
    }

    /**
     * Replaces a substring inside a string with multi-byte support
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @param bool   $case_sensitive
     * @param string $encoding
     * @param null   $count
     *
     * @return array|string
     * @see     https://github.com/faceleg/php-mb_str_replace
     */
    protected static function _mb_str_replace(
        $search,
        $replace,
        $subject,
        $case_sensitive = true,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        if (is_array($subject)) {
            $result = array();
            foreach ($subject as $item) {
                $result[] = static::_mb_str_replace($search, $replace, $item, $case_sensitive, $encoding, $count);
            }

            return $result;
        }

        if (!is_array($search)) {
            return static::_mb_str_replace_i($search, $replace, $subject, $case_sensitive, $encoding, $count);
        }

        $replace_is_array = is_array($replace);
        foreach ($search as $key => $value) {
            $subject = static::_mb_str_replace_i(
                $value,
                ($replace_is_array ? $replace[$key] : $replace),
                $subject,
                $case_sensitive,
                $encoding,
                $count
            );
        }

        return $subject;
    }

    /**
     * Implementation of mb_str_replace. Do not call directly.
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @param bool   $case_sensitive
     * @param string $encoding
     * @param null   $count
     *
     * @return string
     * @see      https://github.com/faceleg/php-mb_str_replace
     */
    protected static function _mb_str_replace_i(
        $search,
        $replace,
        $subject,
        $case_sensitive = true,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        $search_length = mb_strlen($search, $encoding);
        $subject_length = mb_strlen($subject, $encoding);
        $offset = 0;
        $result = '';

        while ($offset < $subject_length) {
            $match = $case_sensitive ? mb_strpos($subject, $search, $offset, $encoding)
                : mb_stripos($subject, $search, $offset, $encoding);
            if ($match === false) {
                if ($offset === 0) {
                    // No match was ever found, just return the subject.
                    return $subject;
                }
                // Append the final portion of the subject to the replaced.
                $result .= mb_substr($subject, $offset, $subject_length - $offset, $encoding);
                break;
            }
            if ($count !== null) {
                $count++;
            }
            $result .= mb_substr($subject, $offset, $match - $offset, $encoding);
            $result .= $replace;
            $offset = $match + $search_length;
        }

        return $result;
    }

    /**
     * Returns a lowercased string.
     *
     * Returns a lowercased string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The functions uses mb_strtolower if present and falls back to strtolower.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input      The input string
     * @param   string $encoding   The encoding of the input string
     *
     * @return  string  The lowercased string
     */
    public static function lower($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtolower')
            ? mb_strtolower($input, $encoding)
            : strtolower($input);
    }

    /**
     * Returns an uppercased string.
     *
     * Returns an uppercased string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The functions uses mb_strtoupper if present and falls back to strtoupper.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input      The input string
     * @param   string $encoding   The encoding of the input string
     *
     * @return  string  The uppercased string
     */
    public static function upper($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtoupper')
            ? mb_strtoupper($input, $encoding)
            : strtoupper($input);
    }

    /**
     * Returns a string with the first char as lowercase.
     *
     * Returns a string with the first char as lowercase. The other characters in the string are left untouched.
     * The $encoding parameter is used to determine the input string encoding and thus use the proper method.
     * The function uses mb_strtolower, mb_mb_substr and mb_strlen if present and falls back to lcfirst.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input      The input string
     * @param   string $encoding   The encoding of the input string
     *
     * @return  string  The string with the first char lowercased
     */
    public static function lcfirst($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtolower')
            ? mb_strtolower(mb_substr($input, 0, 1, $encoding), $encoding) .
            mb_substr($input, 1, mb_strlen($input, $encoding), $encoding)
            : lcfirst($input);
    }

    /**
     * Returns a string with the first char as uppercase.
     *
     * Returns a string with the first char as uppercase. The other characters in the string are left untouched.
     * The $encoding parameter is used to determine the input string encoding and thus use the proper method.
     * The function uses mb_strtoupper, mb_mb_substr and mb_strlen if present and falls back to ucfirst.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input      The input string
     * @param   string $encoding   The encoding of the input string
     *
     * @return  string  The string with the first char uppercased
     */
    public static function ucfirst($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_strtoupper')
            ? mb_strtoupper(mb_substr($input, 0, 1, $encoding), $encoding) .
            mb_substr($input, 1, mb_strlen($input, $encoding), $encoding)
            : ucfirst($input);
    }

    /**
     * Returns a string with the words capitalized.
     *
     * Returns a string with the words capitalized. The $encoding parameter is used to determine the input string
     * encoding and thus use the proper method. The function uses mb_convert_case if present and falls back to ucwords.     *
     * The ucwords function normally does not lowercase the input string first, this function does.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input      The input string
     * @param   string $encoding   The encoding of the input string
     *
     * @return  string  The string with the words capitalized
     */
    public static function ucwords($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_convert_case')
            ? mb_convert_case($input, MB_CASE_TITLE, $encoding)
            : ucwords(strtolower($input));
    }

    /**
     * Verifies if the input string is one of the values of the given array.
     *
     * Verifies if the input string is one of the values of the given array. Each of the values
     * of the array is matched against the input string. The index of the value that matched can
     * be returned instead of the default bool value. The comparison can be case sensitive or
     * case insensitive (it is made with strcmp and strcasecmp respectively).
     *
     * @param   string $input              The input string
     * @param   array  $values             The strings array to look for the input string
     * @param   bool   $case_sensitive     Whether the comparison is case-sensitive
     * @param   bool   $return_index       Whether to return the matched array's item instead
     *
     * @return  bool|int    Whether the input string was found in the array or the item's index if found
     * @throws  \InvalidArgumentException
     */
    public static function isOneOf($input, array $values, $case_sensitive = true, $return_index = false)
    {
        if ($input === null) {
            return false;
        }

        if (!is_string($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a string.");
        }

        foreach ($values as $index => $str) {
            if (!is_string($str)) {
                throw new \InvalidArgumentException("The \$values array must contain only string values.");
            }

            if ($case_sensitive) {
                if (strcmp($input, $str) == 0) {
                    return ($return_index) ? $index : true;
                }
            } else {
                if (strcasecmp($input, $str) == 0) {
                    return ($return_index) ? $index : true;
                }
            }
        }

        return false;
    }

    /**
     * Converts a char(s)-separated string into studly caps.
     *
     * Converts a char(s)-separated string into studly caps. The string can be split using one or more
     * separators (being them a single char or a string). The $encoding parameter is used to determine the
     * input string encoding and thus use the proper method.
     * When the space char is not used as a separator, each word is converted to studly caps on its own,
     * otherwise the result will be a single studly-caps-cased string.
     *
     * @param   string $input          The input string
     * @param   array  $separators     An array containing separators to split the input string
     * @param   string $encoding       The encoding of the input string
     *
     * @return  string  The studly-caps-cased string
     * @throws  \InvalidArgumentException
     */
    public static function studly($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a string.");
        }

        if (!empty($separators)) {
            $pattern = '';
            foreach ($separators as $separator) {
                if (!is_string($separator)) {
                    throw new \InvalidArgumentException("The \$separators array must contain only strings.");
                }

                $pattern .= '|' . preg_quote($separator);
            }
            $pattern = '/(^' . $pattern . ')(.)/';

            $studly = preg_replace_callback($pattern, function($matches) {
                    return strtoupper($matches[2]);
                }, strval($input));
            $words = explode(' ', $studly);
            foreach ($words as &$word) {
                $word = static::ucfirst($word, $encoding);
            }
            $studly = implode(' ', $words);
        } else {
            $studly = $input;
        }

        return $studly;
    }

    /**
     * Converts a char(s)-separated string into camel case.
     *
     * Converts a char(s)-separated string into camel case. The string can be split using one or more
     * separators (being them a single char or a string). The $encoding parameter is used to determine
     * the input string encoding and thus use the proper method.
     * When the space char is not used as a separator, each word is converted to camel case on its own,
     * otherwise the result will be a single camel-cased string.
     *
     * @param   string $input          The input string
     * @param   array  $separators     An array containing separators to split the input string
     * @param   string $encoding       The encoding of the input string
     *
     * @return  string  The camel-cased string
     * @throws  \InvalidArgumentException
     */
    public static function camel($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a string.");
        }

        $camel = static::studly($input, $separators, $encoding);
        $words = explode(' ', $camel);
        foreach ($words as &$word) {
            $word = static::lcfirst($word, $encoding);
        }
        $camel = implode(' ', $words);

        return $camel;
    }

    /**
     * Converts a studly-caps-cased or camel-cased string into a char(s)-separated string using a given separator.
     *
     * Converts a studly-caps-cased or camel-cased string into a char(s)-separated string using a given separator.
     * Additionally it can run one of the following transformation in every separated word (words are split by a
     * space): 'lower', 'upper', 'lcfirst', 'ucfirst', 'ucwords' by using the $transform parameter (other values will
     * be ignored and no transformation will be made thus returning the separated words unmodified).
     *
     * @param   string      $input      The input string
     * @param   null|string $transform  The transformation to be run for each word
     * @param   string      $separator  The separator to be used
     * @param   string      $encoding   The encoding of the input string
     *
     * @return  string  The char(s)-separated string
     * @throws  \InvalidArgumentException
     */
    public static function separated($input, $separator = '_', $transform = null, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($input) or !is_string($separator)) {
            throw new \InvalidArgumentException("The \$input and \$separator parameters must be both strings.");
        }

        if ($separator == '') {
            throw new \InvalidArgumentException("The \$separator parameter must have at least one character.");
        }

        $separated = preg_replace_callback(
            '/(^.[^A-Z]+$)|(^.+?(?=[A-Z]))|( +)(.+?)(?=[A-Z])|([A-Z]+(?=$|[A-Z][a-z])|[A-Z]?[a-z]+)/',
            function ($matches) use ($separator, $transform, $encoding) {
                $transformed = trim($matches[0]);
                $count_matches = count($matches);

                switch ($transform) {
                    case 'lower':
                        $transformed = static::lower($transformed, $encoding);
                        break;
                    case 'upper':
                        $transformed = static::upper($transformed, $encoding);
                        break;
                }

                $transformed = (($count_matches == 5) ? $matches[3] : '') . $transformed;
                $transformed = (($count_matches == 6) ? $separator : '') . $transformed;

                return $transformed;
            },
            $input
        );

        // Do lcfirst, ucfirst and ucwords transformations
        if (static::isOneOf($transform, array('lcfirst', 'ucfirst', 'ucwords'))) {
            $words = explode(' ', $separated);
            foreach ($words as &$word) {
                switch ($transform) {
                    case 'lcfirst':
                        $word = static::lcfirst($word, $encoding);
                        break;
                    case 'ucfirst':
                        $word = static::ucfirst($word, $encoding);
                        break;
                    case 'ucwords':
                        // Because of how mb_convert_case works with MB_CASE_TITLE (underscore delimits words) we
                        // need to simulate it by lower + ucfirst
                        $word = static::ucfirst(static::lower($word, $encoding), $encoding);
                        break;
                }
            }
            $separated = implode(' ', $words);
        }

        return $separated;
    }

    /**
     * Truncates a string to the given length.
     *
     * Truncates a string to the given length. It will optionally preserve HTML tags if $is_html is set to true.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $string        The string to truncate
     * @param   int    $limit         The number of characters to truncate too
     * @param   string $continuation  The string to use to denote it was truncated
     * @param   bool   $is_html       Whether the string has HTML
     *
     * @return  string  The truncated string
     */
    public static function truncate($string, $limit, $continuation = '...', $is_html = false)
    {
        $offset = 0;
        $tags = array();
        if ($is_html) {
            // Handle special characters.
            preg_match_all('/&[a-z]+;/i', strip_tags($string), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[0][1] >= $limit) {
                    break;
                }
                $limit += (static::length($match[0][0]) - 1);
            }

            // Handle all the html tags.
            preg_match_all('/<[^>]+>([^<]*)/', $string, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[0][1] - $offset >= $limit) {
                    break;
                }

                $tag = static::sub(strtok($match[0][0], " \t\n\r\0\x0B>"), 1);
                if ($tag[0] != '/') {
                    $tags[] = $tag;
                } elseif (end($tags) == static::sub($tag, 1)) {
                    array_pop($tags);
                }

                $offset += $match[1][1] - $match[0][1];
            }
        }

        $new_string = static::sub($string, 0, $limit = min(static::length($string), $limit + $offset));
        $new_string .= (static::length($string) > $limit ? $continuation : '');
        $new_string .= count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '';

        return $new_string;
    }

    /**
     * Function sprintf for named variables inside format.
     *
     * Args are only used if found in the format.
     * Predefined tags (which can be overwritten passing them as args):
     * %cr$s -> \r
     * %lf$s -> \n
     * %crlf$s -> \r\n
     * %tab$s -> \t
     *
     * This method is based on the work of Nate Bessette (www.twitter.com/frickenate)
     *
     * @param string $format    The format to replace the named variables into
     * @param array  $args      The args to be replaced (var => replacement).
     *
     * @return string|bool  The string with args replaced or false on error
     * @throws \InvalidArgumentException
     * @throws \BadFunctionCallException
     * @throws \LengthException
     */
    public static function nsprintf($format, array $args = array())
    {
        if (!is_string($format)) {
            throw new \InvalidArgumentException("The format must be a string.");
        }

        // Filter unnamed %s strings that should not be processed
        $filter_regex = '/%s/';
        $format = preg_replace($filter_regex, '#[:~s]#', $format);

        // The pattern to match variables
        $pattern = '/(?<=%)([a-zA-Z0-9_]\w*)(?=\$)/';

        // Add predefined values
        $pool = array('cr' => "\r", 'lf' => "\n", 'crlf' => "\r\n", 'tab' => "\t") + $args;

        // Build args array and substitute variables with numbers
        $args = array();
        for ($pos = 0; preg_match($pattern, $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
            list($var_key, $var_pos) = $match[0];

            if (!array_key_exists($var_key, $pool)) {
                throw new \BadFunctionCallException("Missing argument '${var_key}'.", E_USER_WARNING);
            }

            array_push($args, $pool[$var_key]);
            $format = substr_replace($format, $index = count($args), $var_pos, $word_length = static::length($var_key));
            $pos = $var_pos + $word_length; // skip to end of replacement for next iteration
        }

        // Final check to see that everything is ok
        preg_match_all($pattern, $format, $match, PREG_OFFSET_CAPTURE);
        if (count($match[0]) != count($args)) {
            throw new \LengthException("The number of arguments differs from the number of variables in the format.");
        }

        // Return the original %s strings
        $filter_regex = '/#\[:~s\]#/';

        return preg_replace($filter_regex, '%s', vsprintf($format, $args));
    }

    /**
     * Returns a random string from the given input string.
     *
     * Returns a random string from the given input string. The characters can be shuffled to increase the
     * randomness (entropy) of the function. The $chars parameter must be a string with at least one character.
     * The length of the returned string can be controlled with the $length parameter, but every characters is
     * randomized independently with each loop.
     *
     * @param   int     $length     The length of the output string
     * @param   string  $chars      The pool of characters to randomize from
     * @param   bool    $shuffle    Whether to shuffle the character string to increase randomness (entropy)
     * @return  string  The random string containing random characters from the $chars string
     * @throws  \InvalidArgumentException
     */
    public static function random($length = 1, $chars = self::ALNUM, $shuffle = false)
    {
        if (!is_numeric($length) or $length < 0) {
            throw new \InvalidArgumentException("The \$length parameter must be a positive integer or zero.");
        }

        if (!is_string($chars) or $chars == '') {
            throw new \InvalidArgumentException("The \$chars parameter must be a non-empty string containing a set of characters to pick a random value from.");
        }

        $chars = ($shuffle) ? str_shuffle($chars) : $chars;

        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, static::length($chars) - 1)];
        }

        return $string;
    }

    /**
     * Returns a type-random string.
     *
     * Returns a type-random string. The $type parameter defines the pool of characters to randomize from. The pool
     * can be shuffled to increase the randomness (entropy) of the function. The length of the returned string can be
     * controlled with the $length parameter, but every characters is randomized independetly with each loop.
     *
     * This function is based on FuelPHP's \Fuel\Core\Str random function.
     *
     * @param   string  $type       The type of random string to get
     * @param   int     $length     The length of the output string
     * @param   bool    $shuffle    Whether to shuffle the character pool to increase randomness (entropy)
     * @return  string  The type-random string containing random characters from the proper type pool
     */
    public static function trandom($type = 'alnum', $length = 16, $shuffle = false)
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
                break;
            case 'unique':
                return md5(uniqid(mt_rand()));
                break;
            case 'sha1':
                return sha1(uniqid(mt_rand(), true));
                break;
            case 'alpha':
                $pool = self::ALPHA;
                break;
            case 'alnum':
                $pool = self::ALNUM;
                break;
            case 'numeric':
                $pool = self::NUM;
                break;
            case 'nozero':
                $pool = static::sub(self::NUM, 1);
                break;
            case 'hexdec':
                $pool = self::HEXDEC;
                break;
            case 'distinct':
                $pool = self::DISTINCT;
                break;
            default:
                $pool = self::ALNUM;
                break;
        }

        return static::random($length, $pool, $shuffle);
    }
}
