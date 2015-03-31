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

use axelitus\Base\BoolNot;

/**
 * Class TestsBoolNot
 *
 * @package axelitus\Base
 */
class TestsBoolNot extends TestCase
{
    // region: NOT operation

    public function testValueNot()
    {
        $this->assertTrue(BoolNot::val(false));
        $this->assertFalse(BoolNot::val(true));
        $this->assertEquals([true, false], BoolNot::val(false, true));
        $this->assertEquals([false, true, true], BoolNot::val(true, false, false));
        $this->assertEquals([true, false, false, true, false], BoolNot::val(false, true, true, false, true));
    }

    public function testValueNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolNot::val(true, true, 'string');
    }

    public function testArrayNot()
    {
        $this->assertEquals([true], BoolNot::arr([false]));
        $this->assertEquals([false], BoolNot::arr([true]));
        $this->assertEquals([true, false], BoolNot::arr([false, true]));
        $this->assertEquals([false, true, true], BoolNot::arr([true, false, false]));
        $this->assertEquals([true, false, false, true, false], BoolNot::arr([false, true, true, false, true]));
    }

    public function testArrayNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type array.");
        BoolNot::arr([true, true], [false, false], 'string');
    }

    public function testArrayNotEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolNot::arr([true, true, false, false, 'string']);
    }

    // endregion
}