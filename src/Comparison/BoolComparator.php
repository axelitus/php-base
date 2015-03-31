<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base\Comparison;

use axelitus\Base\Bool;
use axelitus\Base\Comparator;
use Closure;

/**
 * Class BoolComparator
 *
 * Bool comparator implementation.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BoolComparator extends Comparator
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            function ($item1, $item2) {
                if (!Bool::is($item1) || !Bool::is($item2)) {
                    throw new \InvalidArgumentException("The \$item1 and \$item2 parameters must be of type bool.");
                }

                return Bool::compare($item1, $item2);
            }
        );
    }

    /**
     * This comparator does not allow to set the callback outside this class.
     *
     * @param Closure $callback The new callback.
     *
     * @throws \RuntimeException
     */
    public function setCallback(Closure $callback = null)
    {
        if ($this->callback !== null || $callback === null) {
            throw new \RuntimeException("Cannot redeclare this comparator callback.");
        }

        $this->callback = Closure::bind($callback, $this, get_called_class());
    }
}
