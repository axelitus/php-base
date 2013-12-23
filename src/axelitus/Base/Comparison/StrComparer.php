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

namespace axelitus\Base\Comparison;

use axelitus\Base\Comparer;
use \Closure;
use axelitus\Base\Str;
use axelitus\Base\Arr;

/**
 * Class IntComparer
 *
 * Str comparer implementation.
 *
 * @package axelitus\Base
 *
 * @codeCoverageIgnore
 */
class StrComparer extends Comparer
{
    /**
     * Constructor
     */
    public function __construct($caseInsensitive = false)
    {
        parent::__construct(
            function ($item1, $item2) {
                if (!Str::is($item1) || !Str::is($item2)) {
                    throw new \InvalidArgumentException("The \$item1 and \$item2 parameters must be of type string.");
                }

                return Str::compare($item1, $item2, (bool)$this->options['caseInsensitive']);
            }
        );
        $this->options = new Arr(['caseInsensitive' => $caseInsensitive]);
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
