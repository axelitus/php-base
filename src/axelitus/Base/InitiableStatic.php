<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.7.2
 */

namespace axelitus\Base;

/**
 * Interface InitiableStatic
 *
 * Defines the interface for static initiable classes.
 *
 * @package axelitus\Base
 *
 * @codeCoverageIgnore
 */
interface InitiableStatic
{
    public static function initStatic();
}
