<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2016 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base;

/**
 * Interface Comparable
 *
 * Defines the interface for a comparable object.
 *
 * @package axelitus\Base
 */
interface Comparable
{
    // region: Comparison

    /**
     * Compares the instance with another object/value.
     *
     * @param mixed $item The item to compare to.
     *
     * @return mixed
     */
    public function compareTo($item);

    // endregion
}
