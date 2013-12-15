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
 * Defines the interface for initiable objects.
 *
 * @package axelitus\Base
 *
 * @codeCoverageIgnore
 */
interface Initiable
{
    public function init();
}
