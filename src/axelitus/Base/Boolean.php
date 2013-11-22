<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.3
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

use axelitus\Base\Primitives\Boolean\PrimitiveBoolean;

/**
 * Class Boolean
 *
 * Defines a Boolean.
 *
 * @package axelitus\Base
 */
class Boolean extends PrimitiveBoolean
{
    /**
     * @param $operand
     *
     * @return mixed
     */
    public function andWith($operand)
    {
        return call_user_func_array(['axelitus\Base\Primitives\Boolean\PrimitiveBoolean', 'doAnd'], array_merge([$this], func_get_args()));
    }
}
