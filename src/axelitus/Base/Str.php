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

    /**
     * Verifies if a string contains a substring. The $encoding parameter is used to determine the
     * encoding and thus the proper method.
     *
     * @param string $input           The input string to compare to
     * @param string $search          The substring to compare the ending to
     * @param bool   $caseInsensitive Whether the comparison is case-sensitive
     * @param string $encoding        The encoding of the input string
     *
     * @return bool     Whether the input string contains the substring
     */
    public static function contains($input, $search, $caseInsensitive = false, $encoding = self::DEFAULT_ENCODING)
    {
        return (static::pos($input, $search, $caseInsensitive, $encoding) !== false);
    }

    /**
     * Verifies if a string begins with a substring.
     *
     * Uses the multibyte function if available with the given encoding $encoding. The comparison is case-sensitive by default.
     *
     * @param string $input           The input string to compare to.
     * @param string $search          The substring to compare the beginning to.
     * @param bool   $caseInsensitive Whether the comparison is case-sensitive.
     * @param string $encoding        The encoding of the input string.
     *
     * @return bool Returns true if the input string begins with the given search string.
     */
    public static function beginsWith($input, $search, $caseInsensitive = false, $encoding = self::DEFAULT_ENCODING)
    {
        $substr = static::sub($input, 0, static::length($search), $encoding);

        return (static::compare($substr, $search, $caseInsensitive) === 0);
    }

    /**
     * Verifies if a string ends with a substring.
     *
     * Uses the multibyte function if available with the given encoding $encoding. The comparison is case-sensitive by default.
     *
     * @param string $input           The input string to compare to.
     * @param string $search          The substring to compare the ending to.
     * @param bool   $caseInsensitive Whether the comparison is case-sensitive.
     * @param string $encoding        The encoding of the input string.
     *
     * @return bool Returns true if the $input string ends with the given $search string.
     */
    public static function endsWith($input, $search, $caseInsensitive = false, $encoding = self::DEFAULT_ENCODING)
    {
        if (($length = static::length($search, $encoding)) == 0) {
            return true;
        }

        $substr = static::sub($input, -$length, $length, $encoding);

        return (static::compare($substr, $search, $caseInsensitive) === 0);
    }

    /**
     * Verifies if the input string is one of the values of the given array.
     *
     * Verifies if the input string is one of the values of the given array. Each of the values
     * of the array is matched against the input string. The index of the value that matched can
     * be returned instead of the default bool value. The comparison can be case sensitive or
     * case insensitive.
     *
     * @param  string $input           The input string
     * @param  array  $values          The string|PrimitiveString array to look for the input string
     * @param  bool   $caseInsensitive Whether the comparison is case-sensitive
     * @param  bool   $returnIndex     Whether to return the matched array's item instead
     *
     * @return bool|int    Whether the input string was found in the array or the item's index if found
     */
    public static function isOneOf($input, array $values, $caseInsensitive = false, $returnIndex = false)
    {
        if (is_null($input)) {
            return false;
        }

        // TODO: in_array()? or other native function like array_search() perhaps?
        foreach ($values as $index => $str) {
            if (static::equals($input, $str, $caseInsensitive)) {
                return ($returnIndex) ? $index : true;
            }
        }

        return false;
    }

    /**
     * Searches the input string for a match to the regular expression given in pattern.
     *
     * @param string $input   The input string.
     * @param string $pattern The pattern to search for, as a string.
     * @param array  $matches If matches is provided, then it is filled with the results of search.
     *                        $matches[0] will contain the text that matched the full pattern, $matches[1]
     *                        will have the text that matched the first captured parenthesized subpattern,
     *                        and so on.
     * @param int    $flags   The flag modifiers.
     * @param int    $offset  The offset from which to start the search (in bytes).
     *
     * @return int
     * @see http://php.net/manual/en/function.preg-match.php
     */
    public static function match($input, $pattern, array &$matches = null, $flags = 0, $offset = 0)
    {
        return preg_match($pattern, $input, $matches, $flags, $offset);
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

    //endregionregion

    //region Extraction

    /**
     * Returns the portion of string specified by the $start and $length parameters.
     *
     * USes the multibyte function if available with the given encoding $encoding and falls back to substr.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string.
     * @param int    $start    The start index from where to begin extracting.
     * @param int    $length   The length of the extracted substring.
     * @param string $encoding The encoding of the $input string for multibyte functions.
     *
     * @throws \InvalidArgumentException
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
     * Finds the position of the first occurrence of a substring in a string.
     * The $encoding parameter is used to determine the encoding and thus the
     * proper method to be used.
     *
     * @param string $input           The input string to compare to
     * @param string $search          The substring to compare the ending to
     * @param bool   $caseInsensitive Whether the comparison is case-sensitive
     * @param string $encoding        The encoding of the input string
     *
     * @return int|bool Returns the numeric position of the first occurrence of the searched string in the input string.
     *                  If it is not found, it returns false.
     */
    public static function pos($input, $search, $caseInsensitive = false, $encoding = self::DEFAULT_ENCODING)
    {
        if ($caseInsensitive) {
            return function_exists('mb_stripos')
                ? mb_stripos($input, $search, 0, $encoding)
                : (stripos($input, $search) !== false ? true : false);
        } else {
            return function_exists('mb_strpos')
                ? mb_strpos($input, $search, 0, $encoding)
                : (strpos($input, $search) !== false ? true : false);
        }
    }

    //endregion

    //region Replace

    /**
     * Replaces a substring inside a string.
     *
     * @param string $input           The input string
     * @param string $search          The substring to be replaced
     * @param string $replace         The substring replacement
     * @param bool   $caseInsensitive Whether the comparison should be case sensitive
     * @param string $encoding        The encoding of the input string
     * @param int    $count           If passed, this will be set to the number of replacements performed.
     *
     * @return string   The string with the substring replaced
     */
    public static function replace(
        $input,
        $search,
        $replace,
        $caseInsensitive = false,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        return function_exists('mb_strlen')
            ? static::_mb_str_replace($search, $replace, $input, $caseInsensitive, $encoding, $count)
            : (($caseInsensitive)
                ? (str_ireplace($search, $replace, $input, $count))
                : (str_replace($search, $replace, $input, $count)));
    }

    /**
     * Replaces a substring inside a string with multi-byte support
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @param bool   $caseInsensitive
     * @param string $encoding
     * @param int    $count
     *
     * @return array|string
     * @see     https://github.com/faceleg/php-mb_str_replace
     */
    protected static function _mb_str_replace(
        $search,
        $replace,
        $subject,
        $caseInsensitive = false,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        if (is_array($subject)) {
            $result = array();
            foreach ($subject as $item) {
                $result[] = static::_mb_str_replace($search, $replace, $item, $caseInsensitive, $encoding, $count);
            }

            return $result;
        }

        if (!is_array($search)) {
            return static::_mb_str_replace_i($search, $replace, $subject, $caseInsensitive, $encoding, $count);
        }

        $replace_is_array = is_array($replace);
        foreach ($search as $key => $value) {
            $subject = static::_mb_str_replace_i(
                $value,
                ($replace_is_array ? $replace[$key] : $replace),
                $subject,
                $caseInsensitive,
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
     * @param bool   $caseInsensitive
     * @param string $encoding
     * @param int    $count
     *
     * @return string
     * @see      https://github.com/faceleg/php-mb_str_replace
     */
    protected static function _mb_str_replace_i(
        $search,
        $replace,
        $subject,
        $caseInsensitive = false,
        $encoding = self::DEFAULT_ENCODING,
        &$count = null
    ) {
        $search_length = mb_strlen($search, $encoding);
        $subject_length = mb_strlen($subject, $encoding);
        $offset = 0;
        $result = '';

        while ($offset < $subject_length) {
            $match = $caseInsensitive
                ? mb_stripos($subject, $search, $offset, $encoding)
                : mb_strpos($subject, $search, $offset, $encoding);
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
     * Truncates a string to the given length.
     *
     * Truncates a string to the given length. It will optionally preserve HTML tags if $is_html is set to true.
     *
     * @author  FuelPHP (http://fuelphp.com)
     *
     * @param   string $input        The string to truncate
     * @param   int    $limit        The number of characters to truncate too
     * @param   string $continuation The string to use to denote it was truncated
     * @param   bool   $is_html      Whether the string has HTML
     *
     * @return  string  The truncated string
     */
    public static function truncate($input, $limit, $continuation = '...', $is_html = false)
    {
        $offset = 0;
        $tags = array();
        if ($is_html) {
            // Handle special characters.
            preg_match_all('/&[a-z]+;/i', strip_tags($input), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[0][1] >= $limit) {
                    break;
                }
                $limit += (static::length($match[0][0]) - 1);
            }

            // Handle all the html tags.
            preg_match_all('/<[^>]+>([^<]*)/', $input, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
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

        $new_string = static::sub($input, 0, $limit = min(static::length($input), $limit + $offset));
        $new_string .= (static::length($input) > $limit ? $continuation : '');
        $new_string .= count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '';

        return $new_string;
    }

    //endregion

    //region Transforms

    /**
     * Returns a lowercased string.
     *
     * Returns a lowercased string. The $encoding parameter is used to determine the input string encoding
     * and thus use the proper method. The functions uses mb_strtolower if present and falls back to strtolower.
     *
     * @author FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string
     * @param string $encoding The encoding of the input string
     *
     * @return string The lowercased string
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
     * @author FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string
     * @param string $encoding The encoding of the input string
     *
     * @return string The uppercased string
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
     * @author FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string
     * @param string $encoding The encoding of the input string
     *
     * @return string The string with the first char lowercased
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
     * @author FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string
     * @param string $encoding The encoding of the input string
     *
     * @return string The string with the first char uppercased
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
     * @author FuelPHP (http://fuelphp.com)
     *
     * @param string $input    The input string
     * @param string $encoding The encoding of the input string
     *
     * @return string The string with the words capitalized
     */
    public static function ucwords($input, $encoding = self::DEFAULT_ENCODING)
    {
        return function_exists('mb_convert_case')
            ? mb_convert_case($input, MB_CASE_TITLE, $encoding)
            : ucwords(strtolower($input));
    }

    //endregion

    //region Style Transforms

    /**
     * Converts a char(s)-separated string into studly caps.
     *
     * Converts a char(s)-separated string into studly caps. The string can be split using one or more
     * separators (being them a single char or a string). The $encoding parameter is used to determine the
     * input string encoding and thus use the proper method.
     * When the space char is not used as a separator, each word is converted to studly caps on its own,
     * otherwise the result will be a single studly-caps-cased string.
     *
     * @param string $input      The input string
     * @param array  $separators An array containing separators to split the input string
     * @param string $encoding   The encoding of the input string
     *
     * @return string The studly-caps-cased string
     */
    public static function studly($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
        if (!empty($separators)) {
            $pattern = '';
            foreach ($separators as $separator) {
                $pattern .= '|' . preg_quote($separator);
            }
            $pattern = '/(^' . $pattern . ')(.)/';

            $studly = preg_replace_callback(
                $pattern,
                function ($matches) {
                    return strtoupper($matches[2]);
                },
                strval($input)
            );
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
     * @param string $input      The input string
     * @param array  $separators An array containing separators to split the input string
     * @param string $encoding   The encoding of the input string
     *
     * @return string  The camel-cased string
     */
    public static function camel($input, array $separators = array('_'), $encoding = self::DEFAULT_ENCODING)
    {
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
     * @param   string      $input     The input string
     * @param   string      $separator The separator to be used
     * @param   null|string $transform The transformation to be run for each word
     * @param   string      $encoding  The encoding of the input string
     *
     * @return  string  The char(s)-separated string
     * @throws  \InvalidArgumentException
     */
    public static function separated($input, $separator = '_', $transform = null, $encoding = self::DEFAULT_ENCODING)
    {
        if (!is_string($separator) || $separator == '') {
            throw new \InvalidArgumentException("The \$separator parameter must be a non-empty string.");
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

    //endregion

    //region Formatting

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
     * @param string $format The format to replace the named variables into
     * @param array  $args   The args to be replaced (var => replacement).
     *
     * @return string|bool  The string with args replaced or false on error
     * @throws \BadFunctionCallException
     * @throws \LengthException
     */
    public static function nsprintf($format, array $args = array())
    {
        // Filter unnamed %s strings that should not be processed
        $filter_regex = '/%s/';
        $format = preg_replace($filter_regex, '#[:~s]#', $format);

        // The pattern to match variables
        $pattern = '/(?<=%)([a-zA-Z0-9_]\w*)(?=\$)/';

        // Add predefined values
        $pool = array('cr' => "\r", 'lf' => "\n", 'crlf' => "\r\n", 'tab' => "\t") + $args;

        // Build args array and substitute variables with numbers
        $args = array();
        //for ($pos = 0; preg_match($pattern, $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
        for ($pos = 0; static::match($format, $pattern, $match, PREG_OFFSET_CAPTURE, $pos);) {
            list($var_key, $var_pos) = $match[0];

            if (!array_key_exists($var_key, $pool)) {
                throw new \BadFunctionCallException("Missing argument '${var_key}'.", E_USER_WARNING);
            }

            array_push($args, $pool[$var_key]);
            $format = substr_replace($format, $index = count($args), $var_pos, $word_length = static::length($var_key));
            $pos = $var_pos + $word_length; // skip to end of replacement for next iteration
        }

        // TODO: evaluate if this code is really necessary
        // Final check to see that everything is ok
        //preg_match_all($pattern, $format, $match, PREG_OFFSET_CAPTURE);
        //if (count($match[0]) != count($args)) {
        //    throw new \LengthException("The number of arguments differs from the number of variables in the format.");
        //}

        // Return the original %s strings
        $filter_regex = '/#\[:~s\]#/';

        return preg_replace($filter_regex, '%s', vsprintf($format, $args));
    }

    //endregion
}
