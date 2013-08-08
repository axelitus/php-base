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

namespace axelitus\Base\Primitives\Numeric\Types;

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;
use axelitus\Base\String;

abstract class PrimitiveInt extends PrimitiveNumeric
{
    protected function validateValue($value)
    {
        return parent::validateValue($value) and $this->is($value);
    }

    public static function is($var)
    {
        return static::isSimple($var) and (is_int($var) or (strval(intval($var)) === strval($var)));
    }
}
