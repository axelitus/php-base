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

/**
 * Class Arr
 *
 * Defines a dot-notated Arr(ay).
 *
 * @package axelitus\Base
 */
class Arr implements \Countable, \ArrayAccess, \Iterator
{
    /**
     * @var array $data Internal data array.
     */
    protected $data = [];

    /**
     * Creates a new Arr instance.
     *
     * @param array $data An optional array to initialize the Arr instance with.
     */
    public function __construct(array $data = [])
    {
        $this->set($data);
    }

    //region Static Methods

    /**
     * Determines if $var is an array or implements \ArrayAccess.
     *
     * @param mixed $var The value to be tested.
     *
     * @return bool Returns true if $var is an array or implements \ArrayAccess, false otherwise.
     */
    public static function is($var)
    {
        return is_array($var) or $var instanceof \ArrayAccess;
    }

    /**
     * @param $input
     * @param $key
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function dhas($input, $key)
    {
        if (!Int::is($key) and !String::is($key)) {
            throw new \InvalidArgumentException('The $key parameter must be an integer or a string.');
        }

        foreach (explode('.', $key) as $k) {
            if ((is_array($input) and !array_key_exists($k, $input)) or !isset($input[$k])) {
                return false;
            }

            $input = $input[$k];
        }

        return true;
    }

    /**
     * Gets the value(s) from the $input array using a dot-notated $key or array of keys.
     *
     * @param array|\ArrayAccess $input   The input array or \ArrayAccess object
     * @param string|array       $key     The dot-notated key or an array of keys
     * @param mixed              $default The default value
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public static function dget($input, $key, $default = null)
    {
        if (!Arr::is($input)) {
            throw new \InvalidArgumentException('The $input argument must be an array or implement \ArrayAccess.');
        }

        if (is_null($key)) {
            return $input;
        }

        if (is_array($key)) {
            $return = array();
            foreach ($key as $k) {
                $return[$k] = static::dget($input, $k, $default);
            }

            return $return;
        } else {
            foreach (explode('.', $key) as $k) {
                if ((is_array($input) and !array_key_exists($k, $input)) or !isset($input[$k])) {
                    return $default;
                }

                $input = $input[$k];
            }

            return $input;
        }
    }

    /**
     * Sets the value into the $input array using a dot-notated $key or array of key-value pairs.
     *
     * @param array|\ArrayAccess $input The input array or \ArrayAccess object
     * @param string|array       $key   The dot-notated key or an array of key-value pairs
     * @param mixed              $value The value to set
     *
     * @throws \InvalidArgumentException
     */
    public static function dset(&$input, $key, $value = null)
    {
        if (!Arr::is($input)) {
            throw new \InvalidArgumentException('The $input argument must be an array or implement \ArrayAccess.');
        }

        if (is_null($key)) {
            return;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                static::dset($input, $k, $v);
            }
        } else {
            foreach (explode('.', $key) as $k) {
                if (!isset($input[$k]) or !is_array($input[$k])) {
                    $input[$k] = [];
                }

                $input =& $input[$k];
            }

            $input = $value;
        }
    }

    /**
     * @param $input
     * @param $key
     *
     * @return array|bool
     */
    public static function ddelete(&$input, $key)
    {
        if (is_null($key)) {
            return false;
        }

        if (is_array($key)) {
            $return = array();
            foreach ($key as $k) {
                $return[$k] = static::delete($input, $k);
            }

            return $return;
        } else {
            foreach (explode('.', $key) as $k) {
                if ((is_array($input) and !array_key_exists($k, $input)) or !isset($input[$k])) {
                    return false;
                }

                if (Arr::is($input[$k])) {
                    $input = $input[$k];
                } else {
                    unset($input[$k]);
                    return true;
                }
            }
        }
    }

    //endregion

    //region Instance Methods

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return Arr::dhas($this->data, $key);
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::dget($this->data, $key, $default);
    }

    /**
     * @param      $key
     * @param null $value
     */
    public function set($key, $value = null)
    {
        Arr::dset($this->data, $key, $value);
    }

    /**
     * @param $key
     *
     * @return array|bool
     */
    public function delete($key)
    {
        return Arr::ddelete($this->data, $key);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    //endregion

    //region implements \Countable

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->data);
    }

    //endregion

    //region implements \ArrayAccess

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    //endregion

    //region implements \Iterator

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !is_null($this->key());
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        return rewind($this->data);
    }

    //endregion
}
