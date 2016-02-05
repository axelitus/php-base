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

use axelitus\Base\ABoolXor;

/**
 * Class TestsABoolXor
 *
 * @package axelitus\Base
 */
class TestsABoolXor extends TestCase
{
    // region: XOR operation

    public function testValueXor()
    {
        $this->assertFalse(ABoolXor::val(false, false));
        $this->assertTrue(ABoolXor::val(false, true));
        $this->assertTrue(ABoolXor::val(true, false));
        $this->assertFalse(ABoolXor::val(true, true));
        $this->assertTrue(ABoolXor::val(true, false, false, false));
        $this->assertTrue(ABoolXor::val(false, true, true, true, true));
        $this->assertFalse(ABoolXor::val(false, false, false, false));
        $this->assertFalse(ABoolXor::val(true, true, true, true, true));
    }

    public function testValueXorEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolXor::val(true, 'string');
    }

    public function testValueXorEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolXor::val(true, false, false, 'string');
    }

    public function testArrayXor()
    {
        $this->assertFalse(ABoolXor::arr([false, false]));
        $this->assertTrue(ABoolXor::arr([false, true]));
        $this->assertTrue(ABoolXor::arr([true, false]));
        $this->assertFalse(ABoolXor::arr([true, true]));

        $this->assertEquals(
            [false, true, true, false],
            ABoolXor::arr([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testArrayXorEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolXor::arr([true, true], [true, false], 'string');
    }

    public function testArrayXorEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolXor::arr([true, true], [true, false], [true]);
    }

    public function testArrayXorEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolXor::arr([true, false, false], [true, false, 'string']);
    }

    // endregion
}