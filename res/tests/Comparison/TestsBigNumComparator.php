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

namespace axelitus\Base\Tests\Comparison;

use axelitus\Base\Tests\TestCase;
use axelitus\Base\Comparison\BigNumComparator;

/**
 * Tests class BigNumComparator
 *
 * @package axelitus\Base
 * @see BigNumComparator
 */
class TestsBigNumComparator extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Comparison\BigNumComparator The big int comparator to use */
    private $comparator;

    // endregion


    // region: SetUp

    public function setUp()
    {
        $this->comparator = new BigNumComparator(2);
    }

    // endregion

    // region: Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparator->isReady());
        $this->assertEquals(3, $this->comparator->compare(8, 5));
        $this->assertEquals(-2, $this->comparator->compare(5, 7));
        $this->assertEquals(0, $this->comparator->compare(5, 5));
        $this->assertEquals(3, $this->comparator->compare('8', '5'));
        $this->assertEquals(-2, $this->comparator->compare('5', '7'));
        $this->assertEquals(0, $this->comparator->compare('5', '5'));
        $this->assertEquals(3.25, $this->comparator->compare(8.75, 5.5));
        $this->assertEquals(-2.25, $this->comparator->compare(5.5, 7.75));
        $this->assertEquals(0.0, $this->comparator->compare(5.3, 5.3));
        $this->assertEquals(3.25, $this->comparator->compare('8.75', '5.5'));
        $this->assertEquals(-2.25, $this->comparator->compare('5.5', '7.75'));
        $this->assertEquals(0.0, $this->comparator->compare('5.3', '5.3'));
    }

    public function testBasicsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be numeric (or string representing a big number)."
        );
        $this->comparator->compare('string', 5);
    }

    public function testBasicsEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be numeric (or string representing a big number)."
        );
        $this->comparator->compare(8.75, 'string');
    }

    public function testCallbackEx()
    {
        $this->setExpectedException('\RuntimeException', "Cannot redeclare this comparator callback.");
        $this->comparator->setCallback(
            function ($item1, $item2) {
                return $item1 * $item2;
            }
        );
    }

    // endregion
}
