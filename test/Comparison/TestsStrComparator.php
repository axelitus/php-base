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
use axelitus\Base\Comparison\StrComparator;

/**
 * Tests class StrComparator
 *
 * @package axelitus\Base
 * @see StrComparator
 */
class TestsStrComparator extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Comparison\StrComparator The str comparator to use */
    private $comparator;

    // endregion


    // region: SetUp

    public function setUp()
    {
        $this->comparator = new StrComparator();
    }

    // endregion

    // region: Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparator->isReady());
        $this->assertLessThan(0, $this->comparator->compare('String', 'string'));
        $this->assertGreaterThan(0, $this->comparator->compare('string', 'String'));
        $this->assertEquals(0, $this->comparator->compare('string', 'string'));

        $this->comparator->setOption('caseInsensitive', true);
        $this->assertEquals(0, $this->comparator->compare('STRING', 'string'));
    }

    public function testBasicsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type string."
        );
        $this->comparator->compare(true, 'string');
    }

    public function testBasicsEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$item1 and \$item2 parameters must be of type string."
        );
        $this->comparator->compare('string', true);
    }

    public function testCallbackEx()
    {
        $this->setExpectedException('\RuntimeException', "Cannot re-declare this comparator callback.");
        $this->comparator->setCallback(
            function ($item1, $item2) {
                return $item1 * $item2;
            }
        );
    }

    // endregion
}
