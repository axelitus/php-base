<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.1
 */

namespace axelitus\Base;

/**
 * Class Flag
 *
 * Bitwise flag operations.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Flag
{
    /**
     * Determines if the given value is a flag.
     *
     * A flag is considered to be one if it is an int that is a power of 2.
     *
     * @param mixed $value The value to test.
     *
     * @return bool Returns true if the value is considered to be a flag, false otherwise.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function is($value)
    {
        if (Int::is($value) && $value > 0) {
            return (($value & ($value - 1)) == 0);
        }

        return false;
    }

    /**
     * Checks if a flag is set in a given value.
     *
     * @param int $value The value to test the flag on.
     * @param int $flag  The flag to be tested.
     *
     * @return bool Returns true if the flag is set in the value, false otherwise.
     * @throws \InvalidArgumentException
     */
    public static function isOn($value, $flag)
    {
        if (!Int::is($value)) {
            throw new \InvalidArgumentException("The \$value parameter must be of type int.");
        }

        if (!static::is($flag)) {
            throw new \InvalidArgumentException("The \$flag parameter must be of type int and a power of 2.");
        }

        return static::is($value & $flag);
    }

    /**
     * Checks if a flag is not set in a given value.
     *
     * @param int $value The value to test the flag on.
     * @param int $flag  The flag to be tested.
     *
     * @return bool Returns true if the flag is not set in the value, false otherwise.
     * @see isOn
     */
    public static function isOff($value, $flag)
    {
        return !static::isOn($value, $flag);
    }

    /**
     * Sets a flag into a value.
     *
     * @param int       $value The value to set the flag on.
     * @param int|array $flag  The flag(s) to be set.
     *
     * @return int Returns the value with the flag on.
     * @throws \InvalidArgumentException
     */
    public static function setOn($value, $flag)
    {
        if (!Int::is($value)) {
            throw new \InvalidArgumentException("The \$value parameter must be of type int.");
        }

        if (is_array($flag)) {
            $ret = $value;
            foreach ($flag as $item) {
                $ret = static::setOn($ret, $item);
            }
            return $ret;
        } elseif (!static::is($flag)) {
            throw new \InvalidArgumentException("The \$flag parameter must be of type int and a power of 2.");
        }

        return ($value | $flag);
    }

    /**
     * Unsets a flag into a value.
     *
     * @param int       $value The value to unset the flag on.
     * @param int|array $flag  The flag(s) to be unset.
     *
     * @return int Returns the value with the flag off.
     * @throws \InvalidArgumentException
     */
    public static function setOff($value, $flag)
    {
        if (!Int::is($value)) {
            throw new \InvalidArgumentException("The \$value parameter must be of type int.");
        }

        if (is_array($flag)) {
            $ret = $value;
            foreach ($flag as $item) {
                $ret = static::setOff($ret, $item);
            }
            return $ret;
        } elseif (!static::is($flag)) {
            throw new \InvalidArgumentException("The \$flag parameter must be of type int and a power of 2.");
        }

        return ($value & ~($value & $flag));
    }

    /**
     * Gets an array with n consecutive flag values.
     *
     * @param int $count The number of flag values to return.
     *
     * @return array The array containing the n flag values.
     * @throws \InvalidArgumentException
     */
    public static function getValues($count)
    {
        if (!Int::is($count) || $count < 1) {
            throw new \InvalidArgumentException("The \$count parameter must be of type int and greater than zero.");
        }

        $ret = [];
        $flag = 1;
        for ($i = 0; $i < $count; $i++) {
            $ret[] = $flag;
            $flag <<= 1;
        }

        return $ret;
    }

    /**
     * Gets an array with consecutive flag values up to the given power of 2.
     *
     * @param int $power The greater power of 2 to return.
     *
     * @return array The array containing the flag values up to the given power of 2.
     * @throws \InvalidArgumentException
     */
    public static function getPowers($power)
    {
        if (!Int::is($power) || $power < 0) {
            throw new \InvalidArgumentException("The \$power parameter must be of type int and positive.");
        }

        return static::getValues($power + 1);
    }

    /**
     * Assigns consecutive flag values to the given tags in an array.
     *
     * @param array $tags The tags to assign flag values to.
     *
     * @return array The associative array with tags => flag value pairs.
     */
    public static function assignValues(array $tags)
    {
        return array_combine($tags, static::getValues(count($tags)));
    }

    /**
     * Builds a flag mask with the given flags.
     *
     * @param int $flag1 The first flag.
     * @param int $_     More flags.
     *
     * @return int The mask containing all the flags given.
     * @throws \InvalidArgumentException
     */
    public static function buildMask($flag1, $_ = null)
    {
        if (!static::is($flag1)) {
            throw new \InvalidArgumentException("The first parameter must be a flag.");
        }

        $mask = $flag1;
        $args = array_slice(func_get_args(), 1);
        foreach ($args as $flag) {
            if (!static::is($flag)) {
                throw new \InvalidArgumentException("All parameters must be flags.");
            }

            $mask = $mask | $flag;
        }

        return $mask;
    }

    /**
     * Applies the mask to the given value and returns the masked result.
     *
     * @param int $value The value to apply the mask to.
     * @param int $mask  The mask to apply.
     *
     * @return int The masked value result.
     * @throws \InvalidArgumentException
     */
    public static function mask($value, $mask)
    {
        if (!Int::is($value) || !Int::is($mask)) {
            throw new \InvalidArgumentException("Both parameters must be integers.");
        }

        return ($value & $mask);
    }

    /**
     * Matches a value against a mask and see if all te bits set on mask are set in value.
     *
     * @param int $value The value to check.
     * @param int $mask  The mask to check the value against.
     *
     * @return bool Returns true if the mask equals zero or all flags in the mask are set in the value, false otherwise.
     */
    public static function matchMask($value, $mask)
    {
        return (($mask === 0) || (static::mask($value, $mask) === $mask));
    }
}
