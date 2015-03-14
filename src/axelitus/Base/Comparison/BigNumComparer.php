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

namespace axelitus\Base\Comparison;

use axelitus\Base\Arr;
use axelitus\Base\BigNum;
use axelitus\Base\Comparer;
use Closure;

/**
 * Class BigNumComparer
 *
 * BigNum comparer implementation.
 *
 * @package axelitus\Base
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BigNumComparer extends Comparer
{
    /**
     * Constructor
     */
    public function __construct($scale = null)
    {
        parent::__construct(
            function ($item1, $item2) {
                if (!BigNum::is($item1) || !BigNum::is($item2)) {
                    throw new \InvalidArgumentException(
                        "The \$item1 and \$item2 parameters must be numeric (or string representing a big number)."
                    );
                }

                return BigNum::compare($item1, $item2, $this->options['scale']);
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
