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

use axelitus\Base\ABoolOr;

/**
 * Class TestsABoolOr
 *
 * @package axelitus\Base
 */
class TestsABoolOr extends TestCase
{
    // region: OR operation

    public function testValueOr()
    {
        $this->assertTrue(ABoolOr::val(true, true));
        $this->assertTrue(ABoolOr::val(true, false));
        $this->assertTrue(ABoolOr::val(false, false, true, false, false));
        $this->assertFalse(ABoolOr::val(false, false));
        $this->assertFalse(ABoolOr::val(false, false, false, false, false));
    }

    public function testValueOrEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolOr::val(true, 'string');
    }

    public function testValueOrEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolOr::val(false, false, false, 'string');
    }

    public function testArrayOr()
    {
        $this->assertTrue(ABoolOr::arr([true, true]));
        $this->assertTrue(ABoolOr::arr([true, false]));
        $this->assertTrue(ABoolOr::arr([false, false, true, false, false]));
        $this->assertFalse(ABoolOr::arr([false, false]));
        $this->assertFalse(ABoolOr::arr([false, false, false, false, false]));

        $this->assertEquals(
            [true, false, false, true],
            ABoolOr::arr([true, false, false], [false, false, false], [false, false, false], [false, true, true])
        );
    }

    public function testArrayOrEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolOr::arr([true, true], [true, false], 'string');
    }

    public function testArrayOrEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        ABoolOr::arr([true, true], [true, false], [true]);
    }

    public function testArrayOrEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        ABoolOr::arr([false, false, false], [false, false, 'string']);
    }

    // endregion
}