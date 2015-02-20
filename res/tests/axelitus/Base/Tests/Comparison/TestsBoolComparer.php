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

namespace axelitus\Base\Tests\Comparison;

use axelitus\Base\Tests\TestCase;
use axelitus\Base\Comparison\BoolComparer;

/**
 * Class TestsBoolComparer
 *
 * @package axelitus\Base
 */
class TestsBoolComparer extends TestCase
{
    //region Properties

    /** @var \axelitus\Base\Comparison\BoolComparer The bool comparer to use */
    private $comparer;

    //endregion


    //region SetUp

    public function setUp()
    {
        $this->comparer = new BoolComparer();
    }

    //endregion

    //region Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparer->isReady());
        $this->assertEquals(1, $this->comparer->compare(true, false));
        $this->assertEquals(0, $this->comparer->compare(true, true));
        $this->assertEquals(0, $this->comparer->compare(false, false));
        $this->assertEquals(-1, $this->comparer->compare(false, true));
    }

    public function testBasicsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type bool."
        );
        $this->comparer->compare('string', true);
    }

    public function testBasicsEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type bool."
        );
        $this->comparer->compare(false, 'string');
    }

    public function testCallbackEx()
    {
        $this->setExpectedException('\RuntimeException', "Cannot redeclare this comparer callback.");
        $this->comparer->setCallback(
            function ($item1, $item2) {
                return $item1 * $item2;
            }
        );
    }

    //endregion
}
