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

use axelitus\Base\ABoolNot;

/**
 * Class TestsABoolNot
 *
 * @package axelitus\Base
 */
class TestsABoolNot extends TestCase
{
    // region: NOT operation

    public function testValueNot()
    {
        $this->assertTrue(ABoolNot::val(false));
        $this->assertFalse(ABoolNot::val(true));
        $this->assertEquals([true, false], ABoolNot::val(false, true));
        $this->assertEquals([false, true, true], ABoolNot::val(true, false, false));
        $this->assertEquals([true, false, false, true, false], ABoolNot::val(false, true, true, false, true));
    }

    public function testValueNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolNot::val(true, true, 'string');
    }

    public function testArrayNot()
    {
        $this->assertEquals([true], ABoolNot::arr([false]));
        $this->assertEquals([false], ABoolNot::arr([true]));
        $this->assertEquals([true, false], ABoolNot::arr([false, true]));
        $this->assertEquals([false, true, true], ABoolNot::arr([true, false, false]));
        $this->assertEquals([true, false, false, true, false], ABoolNot::arr([false, true, true, false, true]));
    }

    public function testArrayNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type array.");
        ABoolNot::arr([true, true], [false, false], 'string');
    }

    public function testArrayNotEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolNot::arr([true, true, false, false, 'string']);
    }

    // endregion
}