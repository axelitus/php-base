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

use axelitus\Base\Exceptions\NotImplementedException;

/**
 * Class Bool
 *
 * Boolean operations.
 *
 * @package axelitus\Base
 */
class Bool
{
    //region Value testing

    public static function is($value)
    {
        // TODO: define if we will allow known config string values as bool like 'yes', 'on' or even 'true' or leave it for other another function to determine this (extIs maybe).
        return $value === true || $value === false || $value === 0 || $value === 1;
    }

    //endregion

    //region Parsing

    public static function parse($input)
    {
        if (!is_string($input) || empty($input)) {
            throw new \InvalidArgumentException("The \$input parameter must be a non-empty string.");
        }

        if (($input = strtolower($input)) != 'true' && $input != 'false') {
            throw new \RuntimeException("The \$input string cannot be parsed because it does not match 'true' or 'false'.");
        }

        return $input == 'true';
    }

    //endregion

    //region NOT operation

    public static function valNot()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrNot()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixNot()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region AND operation

    public static function valAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixAnd()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region OR operation

    public static function valOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixOr()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region EQ operation

    public static function valEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixEq()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion

    //region XOR operation

    public static function valXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function arrXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    public static function mixXor()
    {
        throw new NotImplementedException("This method is not yet implemented");
    }

    //endregion
}
