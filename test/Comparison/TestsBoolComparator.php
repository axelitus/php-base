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

namespace axelitus\Base\Tests\Comparison;

use axelitus\Base\Tests\TestCase;
use axelitus\Base\Comparison\BoolComparator;

/**
 * Tests class BoolComparator
 *
 * @package axelitus\Base
 * @see BoolComparator
 */
class TestsBoolComparator extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Comparison\BoolComparator The bool comparator to use */
    private $comparator;

    // endregion


    // region: SetUp

    public function setUp()
    {
        $this->comparator = new BoolComparator();
    }

    // endregion

    // region: Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparator->isReady());
        $this->assertEquals(1, $this->comparator->compare(true, false));
        $this->assertEquals(0, $this->comparator->compare(true, true));
        $this->assertEquals(0, $this->comparator->compare(false, false));
        $this->assertEquals(-1, $this->comparator->compare(false, true));
    }

    public function testBasicsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type bool."
        );
        $this->comparator->compare('string', true);
    }

    public function testBasicsEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type bool."
        );
        $this->comparator->compare(false, 'string');
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
