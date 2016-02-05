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

use axelitus\Base\ABoolEq;

/**
 * Class TestsABoolEq
 *
 * @package axelitus\Base
 */
class TestsABoolEq extends TestCase
{
    // region: EQ operation

    public function testValueEq()
    {
        $this->assertTrue(ABoolEq::val(false, false));
        $this->assertFalse(ABoolEq::val(false, true));
        $this->assertFalse(ABoolEq::val(true, false));
        $this->assertTrue(ABoolEq::val(true, true));
        $this->assertTrue(ABoolEq::val(false, false, false, false));
        $this->assertTrue(ABoolEq::val(true, true, true, true, true));
    }

    public function testValueEqEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolEq::val(true, 'string');
    }

    public function testValueEqEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolEq::val(false, false, false, 'string');
    }

    public function testArrayEq()
    {
        $this->assertTrue(ABoolEq::arr([false, false]));
        $this->assertFalse(ABoolEq::arr([false, true]));
        $this->assertFalse(ABoolEq::arr([true, false]));
        $this->assertTrue(ABoolEq::arr([true, true]));

        $this->assertEquals(
            [true, false, false, true],
            ABoolEq::arr([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testArrayEqEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolEq::arr([true, true], [true, false], 'string');
    }

    public function testArrayEqEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolEq::arr([true, true], [true, false], [true]);
    }

    public function testArrayEqEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolEq::arr([false, false, false], [false, false, 'string']);
    }

    // endregion
}