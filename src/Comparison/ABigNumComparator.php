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

namespace axelitus\Base\Comparison;

use axelitus\Base\Arr;
use axelitus\Base\ABigNum;
use axelitus\Base\Comparator;
use Closure;

/**
 * Class ABigNumComparator
 *
 * BigNum comparator implementation.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ABigNumComparator extends Comparator
{
    /**
     * Constructor
     *
     * @param null|int $scale This optional parameter is used to set the number of digits after the decimal place in the result.
     *                        If no scale is given the global default scale will be used.
     * @throws \InvalidArgumentException
     */
    public function __construct($scale = null)
    {
        parent::__construct(
            function ($item1, $item2) {
                if (!ABigNum::is($item1) || !ABigNum::is($item2)) {
                    throw new \InvalidArgumentException(
                        "The \$item1 and \$item2 parameters must be numeric (or string representing a big number)."
                    );
                }

                return ABigNum::compare($item1, $item2, $this->options['scale']);
            }
        );
        $this->options = new Arr(['scale' => $scale]);
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
