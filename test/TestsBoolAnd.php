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

use axelitus\Base\BoolAnd;

/**
 * Class TestsBoolAnd
 *
 * @package axelitus\Base
 */
class TestsBoolAnd extends TestCase
{
    // region: AND operation

    public function testValueAnd()
    {
        $this->assertTrue(BoolAnd::val(true, true));
        $this->assertFalse(BoolAnd::val(true, false));
        $this->assertTrue(BoolAnd::val(true, true, true, true, true));
        $this->assertFalse(BoolAnd::val(true, true, true, false, true));
    }

    public function testValueAndEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolAnd::val(true, 'string');
    }

    public function testValueAndEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolAnd::val(true, true, true, 'string');
    }

    public function testArrayAnd()
    {
        $this->assertTrue(BoolAnd::arr([true, true]));
        $this->assertFalse(BoolAnd::arr([true, false]));
        $this->assertTrue(BoolAnd::arr([true, true, true, true, true]));
        $this->assertFalse(BoolAnd::arr([true, true, true, false, true]));

        $this->assertEquals(
            [true, false, false, true],
            BoolAnd::arr([true, true, true], [true, false, true], [false, false, true], [true, true, true])
        );
    }

    public function testArrayAndEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolAnd::arr([true, true], [true, false], 'string');
    }

    public function testArrayAndEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolAnd::arr([true, true], [true, false], [true]);
    }

    public function testArrayAndEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolAnd::arr([true, true, true], [true, true, 'string']);
    }

    // endregion
}