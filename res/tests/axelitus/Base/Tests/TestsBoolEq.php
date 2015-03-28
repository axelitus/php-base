<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base\Tests;

use axelitus\Base\BoolEq;

/**
 * Class TestsBoolEq
 *
 * @package axelitus\Base
 */
class TestsBoolEq extends TestCase
{
    // region: EQ operation

    public function testValueEq()
    {
        $this->assertTrue(BoolEq::val(false, false));
        $this->assertFalse(BoolEq::val(false, true));
        $this->assertFalse(BoolEq::val(true, false));
        $this->assertTrue(BoolEq::val(true, true));
        $this->assertTrue(BoolEq::val(false, false, false, false));
        $this->assertTrue(BoolEq::val(true, true, true, true, true));
    }

    public function testValueEqEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolEq::val(true, 'string');
    }

    public function testValueEqEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolEq::val(false, false, false, 'string');
    }

    public function testArrayEq()
    {
        $this->assertTrue(BoolEq::arr([false, false]));
        $this->assertFalse(BoolEq::arr([false, true]));
        $this->assertFalse(BoolEq::arr([true, false]));
        $this->assertTrue(BoolEq::arr([true, true]));

        $this->assertEquals(
            [true, false, false, true],
            BoolEq::arr([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testArrayEqEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolEq::arr([true, true], [true, false], 'string');
    }

    public function testArrayEqEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolEq::arr([true, true], [true, false], [true]);
    }

    public function testArrayEqEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolEq::arr([false, false, false], [false, false, 'string']);
    }

    // endregion
}