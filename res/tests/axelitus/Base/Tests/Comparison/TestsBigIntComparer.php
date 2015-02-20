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
use axelitus\Base\Comparison\BigIntComparer;

/**
 * Class TestsBigIntComparer
 *
 * @package axelitus\Base
 */
class TestsBigIntComparer extends TestCase
{
    //region Properties

    /** @var \axelitus\Base\Comparison\BigIntComparer The big int comparer to use */
    private $comparer;

    //endregion


    //region SetUp

    public function setUp()
    {
        $this->comparer = new BigIntComparer();
    }

    //endregion

    //region Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparer->isReady());
        $this->assertEquals(3, $this->comparer->compare(8, 5));
        $this->assertEquals(-2, $this->comparer->compare(5, 7));
        $this->assertEquals(0, $this->comparer->compare(5, 5));
        $this->assertEquals(3, $this->comparer->compare('8', '5'));
        $this->assertEquals(-2, $this->comparer->compare('5', '7'));
        $this->assertEquals(0, $this->comparer->compare('5', '5'));
    }

    public function testBasicsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type int (or string representing a big int)."
        );
        $this->comparer->compare('string', 5);
    }

    public function testBasicsEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type int (or string representing a big int)."
        );
        $this->comparer->compare(8, 'string');
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
