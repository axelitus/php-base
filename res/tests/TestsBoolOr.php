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

use axelitus\Base\BoolOr;

/**
 * Class TestsBoolOr
 *
 * @package axelitus\Base
 */
class TestsBoolOr extends TestCase
{
    // region: OR operation

    public function testValueOr()
    {
        $this->assertTrue(BoolOr::val(true, true));
        $this->assertTrue(BoolOr::val(true, false));
        $this->assertTrue(BoolOr::val(false, false, true, false, false));
        $this->assertFalse(BoolOr::val(false, false));
        $this->assertFalse(BoolOr::val(false, false, false, false, false));
    }

    public function testValueOrEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolOr::val(true, 'string');
    }

    public function testValueOrEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolOr::val(false, false, false, 'string');
    }

    public function testArrayOr()
    {
        $this->assertTrue(BoolOr::arr([true, true]));
        $this->assertTrue(BoolOr::arr([true, false]));
        $this->assertTrue(BoolOr::arr([false, false, true, false, false]));
        $this->assertFalse(BoolOr::arr([false, false]));
        $this->assertFalse(BoolOr::arr([false, false, false, false, false]));

        $this->assertEquals(
            [true, false, false, true],
            BoolOr::arr([true, false, false], [false, false, false], [false, false, false], [false, true, true])
        );
    }

    public function testArrayOrEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolOr::arr([true, true], [true, false], 'string');
    }

    public function testArrayOrEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        BoolOr::arr([true, true], [true, false], [true]);
    }

    public function testArrayOrEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        BoolOr::arr([false, false, false], [false, false, 'string']);
    }

    // endregion
}