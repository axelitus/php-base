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

use axelitus\Base\Arr;
use axelitus\Base\BigInt;
use axelitus\Base\Comparer;
use Closure;

/**
 * Class BigIntComparer
 *
 * BigInt comparer implementation.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BigIntComparer extends Comparer
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
                if (!BigInt::is($item1) || !BigInt::is($item2)) {
                    throw new \InvalidArgumentException(
                        "The \$item1 and \$item2 parameters must be of type int (or string representing a big int)."
                    );
                }

                return BigInt::compare($item1, $item2);
            }
        );
        $this->options = new Arr(['scale' => $scale]);
    }

    /**
     * This comparer does not allow to set the callback outside this class.
     *
     * @param Closure $callback The new callback.
     *
     * @throws \RuntimeException
     */
    public function setCallback(Closure $callback = null)
    {
        if ($this->callback !== null || $callback === null) {
            throw new \RuntimeException("Cannot redeclare this comparer callback.");
        }

        $this->callback = Closure::bind($callback, $this, get_called_class());
    }
}
