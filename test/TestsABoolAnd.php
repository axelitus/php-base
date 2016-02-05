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

namespace axelitus\Base\Tests;

use axelitus\Base\ABoolAnd;

/**
 * Class TestsABoolAnd
 *
 * @package axelitus\Base
 */
class TestsABoolAnd extends TestCase
{
    // region: AND operation

    public function testValueAnd()
    {
        $this->assertTrue(ABoolAnd::val(true, true));
        $this->assertFalse(ABoolAnd::val(true, false));
        $this->assertTrue(ABoolAnd::val(true, true, true, true, true));
        $this->assertFalse(ABoolAnd::val(true, true, true, false, true));
    }

    public function testValueAndEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolAnd::val(true, 'string');
    }

    public function testValueAndEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolAnd::val(true, true, true, 'string');
    }

    public function testArrayAnd()
    {
        $this->assertTrue(ABoolAnd::arr([true, true]));
        $this->assertFalse(ABoolAnd::arr([true, false]));
        $this->assertTrue(ABoolAnd::arr([true, true, true, true, true]));
        $this->assertFalse(ABoolAnd::arr([true, true, true, false, true]));

        $this->assertEquals(
            [true, false, false, true],
            ABoolAnd::arr([true, true, true], [true, false, true], [false, false, true], [true, true, true])
        );
    }

    public function testArrayAndEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolAnd::arr([true, true], [true, false], 'string');
    }

    public function testArrayAndEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolAnd::arr([true, true], [true, false], [true]);
    }

    public function testArrayAndEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolAnd::arr([true, true, true], [true, true, 'string']);
    }

    // endregion
}