<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.0
 */

namespace axelitus\Base;

/**
 * Interface Initiable
 *
 * Defines the interface for initiable classes (simulates a static constructor).
 *
 * @package axelitus\Base
 *
 * @codeCoverageIgnore
 */
interface Initiable
{
    /**
     * Initiates a class (simulating a static constructor)
     *
     * @param array $options The options to initialize if available as an associative array.
     *
     * @return bool Returns true when the class was successfully initiated, false otherwise.
     */
    public static function init($options = []);
}