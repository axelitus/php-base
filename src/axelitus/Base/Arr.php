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
 * Class Arr
 *
 * Dot-Notated Array object.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Arr implements \ArrayAccess, \Countable, \Iterator
{
    //region Properties

    /**
     * @var array The internal dot-notated array.
     */
    private $data = [];

    //endregion

    //region Constructors

    /**
     * Constructor
     *
     * The given initial data will be converted using DotArr::convert().
     * Values may be lost, {@link DotArr::convert}.
     *
     * @param array $data The initial value for the Arr object.
     */
    public function __construct(array $data = [])
    {
        $this->data = DotArr::convert($data);
    }

    //endregion

    //region Get & Set

    /**
     * Gets a value from the dot-notated internal array.
     *
     * @param int|string|array $key     The key of the item's value to get or an array of keys.
     * @param mixed            $default A default value to return if the item is not found.
     *
     * @return mixed The value of the item if found, the default value otherwise.
     * @see DotArr::get
     */
    public function get($key, $default = null)
    {
        return DotArr::get($this->data, $key, $default);
    }

    /**
     * Sets a value to the dot-notated internal array.
     *
     * @param int|string|array $key   The key of the item to be set or an array of key=>value pairs.
     * @param mixed            $value The value to be set to the item.
     *
     * @see DotArr::set
     */
    public function set($key, $value = null)
    {
        DotArr::set($this->data, $key, $value);
    }

    /**
     * Deletes an item from the dot-notated internal array.
     *
     * @param int|string|array $key The key of the item to delete or an array of keys.
     *
     * @return bool|array Returns true if the item was found and deleted, false otherwise (or array of results).
     *
     * @see DotArr::delete
     */
    public function delete($key)
    {
        return DotArr::delete($this->data, $key);
    }

    //endregion

    //region Matches

    /**
     * Checks if the dot-notated internal array has the given key.
     *
     * @param int|string|array $key The key to check or array of keys.
     *
     * @return bool|array Returns true if the array has the key, false otherwise (or an array of results).
     * @see DotArr::keyExists
     */
    public function has($key)
    {
        return DotArr::keyExists($this->data, $key);
    }

    //endregion

    //region Conversion

    /**
     * Get the data as a simple array.
     *
     * @return array The containing data as a simple array.
     */
    public function asArray()
    {
        return $this->data;
    }

    //endregion

    //region Implements \ArrayAccess

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
        $ret = $this->has($offset);
        return (is_array($ret)? (bool)Bool::arrayAnd($ret) : $ret);
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

    //region Implements \Countable

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     *
     * @param null|int|string|array $key The key to get the count from.
     *
     * @throws \InvalidArgumentException
     * @return int|array The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count($key = null)
    {
        if (is_null($key)) {
            return count($this->data);
        }

        if (is_array($key)) {
            $return = [];
            foreach ($key as $k) {
                $return[$k] = $this->count($k);
            }

            return $return;
        }

        if (!Int::is($key) && !Str::is($key)) {
            throw new \InvalidArgumentException("The \$key parameter must be int or string (or array of them).");
        }

        if (!$this->has($key)) {
            return false;
        }

        return count($this->get($key));
    }

    //endregion

    //region Implements \Iterator

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
        return ($this->key() !== null);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->data);
    }

    //endregion
}
