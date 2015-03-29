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

use axelitus\Base\BoolXor;

/**
 * Class TestsBoolXor
 *
 * @package axelitus\Base
 */
class TestsBoolXor extends TestCase
{
    // region: XOR operation

    public function testValueXor()
    {
        $this->assertFalse(BoolXor::val(false, false));
        $this->assertTrue(BoolXor::val(false, true));
        $this->assertTrue(BoolXor::val(true, false));
        $this->assertFalse(BoolXor::val(true, true));
        $this->assertTrue(BoolXor::val(true, false, false, false));
        $this->assertTrue(BoolXor::val(false, true, true, true, true));
        $this->assertFalse(BoolXor::val(false, false, false, false));
        $this->assertFalse(BoolXor::val(true, true, true, true, true));
    }

    public function testValueXorEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolXor::val(true, 'string');
    }

    public function testValueXorEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolXor::val(true, false, false, 'string');
    }

    public function testArrayXor()
    {
        $this->assertFalse(BoolXor::arr([false, false]));
        $this->assertTrue(BoolXor::arr([false, true]));
        $this->assertTrue(BoolXor::arr([true, false]));
        $this->assertFalse(BoolXor::arr([true, true]));

        $this->assertEquals(
            [false, true, true, false],
            BoolXor::arr([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testArrayXorEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolXor::arr([true, true], [true, false], 'string');
    }

    public function testArrayXorEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolXor::arr([true, true], [true, false], [true]);
    }

    public function testArrayXorEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolXor::arr([true, false, false], [true, false, 'string']);
    }

    // endregion
}