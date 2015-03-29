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
 * Class TestsComparer
 *
 * @package axelitus\Base
 */
class TestsComparer extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Comparer The comparer to use */
    private $comparer;

    // endregion


    // region: SetUp

    public function setUp()
    {
        $this->comparer = $this->getMockForAbstractClass('\axelitus\Base\Comparer');
    }

    // endregion

    // region: Basics

    public function testBasics()
    {
        $callback = function ($item1, $item2) {
            return $item1 - $item2;
        };
        $this->assertFalse($this->comparer->isReady());
        $this->comparer->setCallback($callback);
        $this->assertTrue($this->comparer->isReady());
        $this->assertEquals($callback, $this->comparer->getCallback());
        $this->assertEquals(3, $this->comparer->compare(8, 5));
        $this->assertEquals(-2, $this->comparer->compare(5, 7));
        $this->assertEquals(0, $this->comparer->compare(5, 5));
    }

    // endregion

    // region: Options

    public function testOptions()
    {
        $this->assertFalse($this->comparer->isReady());
        $this->comparer->setCallback(
            function ($item1, $item2) {
                /** @var object $this \axelitus\Base\Comparer */
                if ($this->options['first.double'] !== null) {
                    return ($item1 * 2) - $item2;
                } else {
                    return ($item1 - $item2);
                }
            }
        );
        $this->assertTrue($this->comparer->isReady());
        $this->assertEquals(3, $this->comparer->compare(8, 5));
        $this->comparer->setOption('first.double', true);
        $this->assertEquals(11, $this->comparer->compare(8, 5));
        $this->assertEquals(true, $this->comparer->getOption('first.double'));

        $options = $this->getNonPublicPropertyValue($this->comparer, 'options')->asArray();
        $this->assertArrayHasKey('first', $options);
        $this->assertArrayHasKey('double', $options['first']);
        $this->comparer->deleteOption('first.double');
        $options = $this->getNonPublicPropertyValue($this->comparer, 'options')->asArray();
        $this->assertArrayHasKey('first', $options);
        $this->assertArrayNotHasKey('double', $options['first']);
    }

    // endregion

    // region: Compare

    public function testCompareEx01()
    {
        $this->setExpectedException('\RuntimeException', "The comparer is not ready, no valid callback has been set.");
        $this->comparer->compare('A', 'A');
    }

    // endregion
}
