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
     * Applies the boolean AND operation to the object and the given operand(s).
     *
     * @param bool|PrimitiveBoolean|array $operand,... The operand(s) to apply the AND operation with.
     *
     * @return bool The result of the boolean AND operation
     */
    public function andWith($operand)
    {
        return call_user_func_array(['axelitus\Base\Primitives\Boolean\PrimitiveBoolean', 'doAnd'], array_merge([$this], func_get_args()));
    }

    /**
     * Applies the boolean OR operation to the object and the given operand(s).
     *
     * @param bool|PrimitiveBoolean|array $operand,... The operand(s) to apply the OR operation with.
     *
     * @return bool|array The result of the boolean OR operation
     */
    public function orWith($operand) {
        return call_user_func_array(['axelitus\Base\Primitives\Boolean\PrimitiveBoolean', 'doOr'], array_merge([$this], func_get_args()));
    }

    /**
     * Applies the boolean EQ (equality) operation to the object and the given operand(s).
     *
     * @param bool|PrimitiveBoolean|array The operand(s) to apply the EQ operation with.
     *
     * @return bool|array  The result of the boolean EQ operation
     */
    public function eqWith($operands) {
        return call_user_func_array(['axelitus\Base\Primitives\Boolean\PrimitiveBoolean', 'doEq'], array_merge([$this], func_get_args()));
    }

    /**
     * Applies the boolean XOR operation to the object and the given operand.
     *
     * @param bool|PrimitiveBoolean $operand The operand to apply the XOR operation with.
     *
     * @return bool The result of the boolean XOR operation
     */
    public function xorWith($operand) {
        return call_user_func_array(['axelitus\Base\Primitives\Boolean\PrimitiveBoolean', 'doXor'], array_merge([$this], func_get_args()));
    }
}
