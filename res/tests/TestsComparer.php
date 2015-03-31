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

namespace axelitus\Base\Tests;

/**
 * Class TestsComparator
 *
 * @package axelitus\Base
 */
class TestsComparator extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Comparator The comparator to use */
    private $comparator;

    // endregion


    // region: SetUp

    public function setUp()
    {
        $this->comparator = $this->getMockForAbstractClass('\axelitus\Base\Comparator');
    }

    // endregion

    // region: Basics

    public function testBasics()
    {
        $callback = function ($item1, $item2) {
            return $item1 - $item2;
        };
        $this->assertFalse($this->comparator->isReady());
        $this->comparator->setCallback($callback);
        $this->assertTrue($this->comparator->isReady());
        $this->assertEquals($callback, $this->comparator->getCallback());
        $this->assertEquals(3, $this->comparator->compare(8, 5));
        $this->assertEquals(-2, $this->comparator->compare(5, 7));
        $this->assertEquals(0, $this->comparator->compare(5, 5));
    }

    // endregion

    // region: Options

    public function testOptions()
    {
        $this->assertFalse($this->comparator->isReady());
        $this->comparator->setCallback(
            function ($item1, $item2) {
                /** @var object $this \axelitus\Base\Comparator */
                if ($this->options['first.double'] !== null) {
                    return ($item1 * 2) - $item2;
                } else {
                    return ($item1 - $item2);
                }
            }
        );
        $this->assertTrue($this->comparator->isReady());
        $this->assertEquals(3, $this->comparator->compare(8, 5));
        $this->comparator->setOption('first.double', true);
        $this->assertEquals(11, $this->comparator->compare(8, 5));
        $this->assertEquals(true, $this->comparator->getOption('first.double'));

        $options = $this->getNonPublicPropertyValue($this->comparator, 'options')->asArray();
        $this->assertArrayHasKey('first', $options);
        $this->assertArrayHasKey('double', $options['first']);
        $this->comparator->deleteOption('first.double');
        $options = $this->getNonPublicPropertyValue($this->comparator, 'options')->asArray();
        $this->assertArrayHasKey('first', $options);
        $this->assertArrayNotHasKey('double', $options['first']);
    }

    // endregion

    // region: Compare

    public function testCompareEx01()
    {
        $this->setExpectedException('\RuntimeException', "The comparator is not ready, no valid callback has been set.");
        $this->comparator->compare('A', 'A');
    }

    // endregion
}
