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

namespace axelitus\Base\Primitives;

use axelitus\Base\Exceptions\NotImplementedException;

/**
 * Class Primitive
 *
 * @package axelitus\Base\Primitives
 */
abstract class Primitive
{
    /**
     * @type int $value The value of the primitive.
     */
    protected $value = 0;

    /**
     * Constructor
     *
     * @param mixed $value The value of the primitive.
     *
     * @throws \InvalidArgumentException
     */
    final public function __construct($value)
    {
        if (!$this->validateValue($value)) {
            throw new \InvalidArgumentException("The \$value '{$value}' is not a correct value for this Primitive.");
        }

        $this->value = $value;
    }

    /**
     * Validates the given primitive value. This function is automatically called from the constructor.
     *
     * @param mixed $value The value of the primitive.
     *
     * @return bool Returns true if the value is valid for the primitive, false otherwise.
     */
    abstract protected function validateValue($value);

    /**
     * Determines if $var is of the primitive type. This function must be overridden by all derivable
     * classes to implement their own algorithm to determine the result of this function.
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is of the type that the called class represents, false otherwise.
     * @throws \axelitus\Base\Exceptions\NotImplementedException
     */
    public static function is($var)
    {
        throw new NotImplementedException("This method is not yet implemented.");
    }

    /**
     * Determines if $var is of a simple type (numeric, string, boolean).
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is a simple primitive type, false otherwise.
     */
    final public static function isSimple($var)
    {
        return !self::isComplex($var);
    }

    /**
     * Determines if $var is of a complex type (array, object, resource).
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is a complex primitive type, false otherwise.
     */
    final public static function isComplex($var)
    {
        return is_array($var) or is_object($var) or is_resource($var);
    }

    /**
     * Gets the primitive's value.
     *
     * @return mixed The primitive's value.
     */
    final public function value()
    {
        return $this->value;
    }

    /**
     * Gets the type of the primitive object.
     *
     * @return string The type of the primitive object.
     */
    final public function getType()
    {
        return gettype($this);
    }

    /**
     * Gets the type of the value stored in the primitive object.
     *
     * @return string The type of the value stored in the primitive object.
     */
    final public function getValueType()
    {
        return gettype($this->value);
    }

    /**
     * Determines if both given values are equal.
     *
     * For this implementation, in this case equal is the same as identical.
     *
     * @param int|float|Numeric\PrimitiveNumeric $a The first of the values to compare.
     * @param int|float|Numeric\PrimitiveNumeric $b The second of the values to compare.
     *
     * @return bool Returns true if both values are numeric and are equal, false otherwise.
     * @throws \axelitus\Base\Exceptions\NotImplementedException
     */
    public static function areEqual($a, $b)
    {
        throw new NotImplementedException("This method is not yet implemented.");
    }
}
