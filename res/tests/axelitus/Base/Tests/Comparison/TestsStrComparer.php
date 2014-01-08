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

namespace axelitus\Base\Tests\Comparison;

use axelitus\Base\Tests\TestCase;
use axelitus\Base\Comparison\StrComparer;

/**
 * Class TestsStrComparer
 *
 * @package axelitus\Base
 */
class TestsStrComparer extends TestCase
{
    //region Properties

    /** @var \axelitus\Base\Comparison\StrComparer The str comparer to use */
    private $comparer;

    //endregion


    //region SetUp

    public function setUp()
    {
        $this->comparer = new StrComparer();
    }

    //endregion

    //region Basics

    public function testBasics()
    {
        $this->assertTrue($this->comparer->isReady());
        $this->assertLessThan(0, $this->comparer->compare('String', 'string'));
        $this->assertGreaterThan(0, $this->comparer->compare('string', 'String'));
        $this->assertEquals(0, $this->comparer->compare('string', 'string'));

        $this->comparer->setOption('caseInsensitive', true);
        $this->assertEquals(0, $this->comparer->compare('STRING', 'string'));
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