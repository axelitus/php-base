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

abstract class PrimitiveFloat extends PrimitiveNumeric
{
    protected function validateValue($value)
    {
        return parent::validateValue($value) and $this->is($value);
    }

    public static function is($var, $strict = false)
    {
        return static::isSimple($var) and (is_float($var) or (strval(floatval($var)) === strval($var)));
    }
}
