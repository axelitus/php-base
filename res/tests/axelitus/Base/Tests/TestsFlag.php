<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.0
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Flag;

/**
 * Class TestsFlag
 *
 * @package axelitus\Base
 */
class TestsFlag extends TestCase
{
    public function testIs()
    {
        $this->assertTrue(Flag::is(0b1));
        $this->assertTrue(Flag::is(0b001));
        $this->assertTrue(Flag::is(0b10));
        $this->assertTrue(Flag::is(0b100));
        $this->assertTrue(Flag::is(0b01000));
        $this->assertTrue(Flag::is(0b10000000));

        $this->assertFalse(Flag::is(0b0));
        $this->assertFalse(Flag::is(0b11));
        $this->assertFalse(Flag::is(0b101));
        $this->assertFalse(Flag::is(0b010001));
        $this->assertFalse(Flag::is(0b1000000001));
        $this->assertFalse(Flag::is(0b100010111));
    }

    public function testIsOn()
    {
        $this->assertTrue(Flag::isOn(0b01001010, 0b01000000));
        $this->assertTrue(Flag::isOn(0b01001010, 0b00001000));
        $this->assertTrue(Flag::isOn(0b01001010, 0b00000010));

        $this->assertFalse(Flag::isOn(0b01001010, 0b10000000));
        $this->assertFalse(Flag::isOn(0b01001010, 0b00100000));
        $this->assertFalse(Flag::isOn(0b01001010, 0b00010000));
        $this->assertFalse(Flag::isOn(0b01001010, 0b00000100));
        $this->assertFalse(Flag::isOn(0b01001010, 0b00000001));
    }

    public function testIsOnEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        Flag::isOn('string', 0b00001);
    }

    public function testIsOnEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$flag parameter must be of type int and a power of 2."
        );
        Flag::isOn(0b00100, 0b00101);
    }

    public function testIsOff()
    {
        $this->assertTrue(Flag::isOff(0b01001010, 0b10000000));
        $this->assertTrue(Flag::isOff(0b01001010, 0b00100000));
        $this->assertTrue(Flag::isOff(0b01001010, 0b00010000));
        $this->assertTrue(Flag::isOff(0b01001010, 0b00000100));
        $this->assertTrue(Flag::isOff(0b01001010, 0b00000001));

        $this->assertFalse(Flag::isOff(0b01001010, 0b01000000));
        $this->assertFalse(Flag::isOff(0b01001010, 0b00001000));
        $this->assertFalse(Flag::isOff(0b01001010, 0b00000010));
    }

    public function testSetOn()
    {
        $this->assertEquals(0b00001, Flag::setOn(0b00000, 0b00001));
        $this->assertEquals(0b01001, Flag::setOn(0b00001, 0b01000));
        $this->assertEquals(0b01101, Flag::setOn(0b01001, 0b00100));

        $this->assertEquals(0b01101, Flag::setOn(0b01101, 0b00100));

        $this->assertEquals(0b11101, Flag::setOn(0b01101, 0b10000));
        $this->assertEquals(0b11111, Flag::setOn(0b11101, 0b00010));

        $this->assertEquals(0b11101, Flag::setOn(0b01001, [0b10000, 0b00100]));
    }

    public function testSetOnEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        Flag::setOn('string', 0b00001);
    }

    public function testSetOnEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$flag parameter must be of type int and a power of 2."
        );
        Flag::setOn(0b00100, 0b00101);
    }

    public function testSetOff()
    {
        $this->assertEquals(0b11011, Flag::setOff(0b11111, 0b00100));
        $this->assertEquals(0b01011, Flag::setOff(0b11011, 0b10000));
        $this->assertEquals(0b01010, Flag::setOff(0b01011, 0b00001));

        $this->assertEquals(0b01010, Flag::setOff(0b01010, 0b00001));

        $this->assertEquals(0b01000, Flag::setOff(0b01010, 0b00010));
        $this->assertEquals(0b00000, Flag::setOff(0b01000, 0b01000));

        $this->assertEquals(0b01001, Flag::setOff(0b11101, [0b10000, 0b00100]));
    }

    public function testSetOffEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        Flag::setOff('string', 0b00001);
    }

    public function testSetOffEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$flag parameter must be of type int and a power of 2."
        );
        Flag::setOff(0b00100, 0b00101);
    }

    public function testGetValues()
    {
        $this->assertEquals([1], Flag::getValues(1));
        $this->assertEquals([1, 2], Flag::getValues(2));
        $this->assertEquals([1, 2, 4, 8, 16], Flag::getValues(5));
        $this->assertEquals([1, 2, 4, 8, 16, 32, 64, 128, 256, 512], Flag::getValues(10));
        $this->assertEquals([1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048], Flag::getValues(12));
    }

    public function testGetValuesEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$count parameter must be of type int and greater than zero."
        );
        Flag::getValues('string');
    }

    public function testGetValuesEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$count parameter must be of type int and greater than zero."
        );
        Flag::getValues(0);
    }

    public function testGetPowers()
    {
        $this->assertEquals([1], Flag::getPowers(0));
        $this->assertEquals([1, 2], Flag::getPowers(1));
        $this->assertEquals([1, 2, 4, 8, 16], Flag::getPowers(4));
        $this->assertEquals([1, 2, 4, 8, 16, 32, 64, 128, 256, 512], Flag::getPowers(9));
        $this->assertEquals([1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048], Flag::getPowers(11));
    }

    public function testGetPowersEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$power parameter must be of type int and positive."
        );
        Flag::getPowers('string');
    }

    public function testGetPowersEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$power parameter must be of type int and positive."
        );
        Flag::getPowers(-1);
    }

    public function testAssignValues()
    {
        $this->assertEquals(
            ['a' => 1, 'b' => 2, 'c' => 4, 'd' => 8, 'e' => 16],
            Flag::assignValues(['a', 'b', 'c', 'd', 'e'])
        );
        $this->assertEquals(
            [0 => 1, 1 => 2, 2 => 4, 3 => 8, 4 => 16, 5 => 32],
            Flag::assignValues([0, 1, 2, 3, 4, 5])
        );
    }

    public function testBuildMask()
    {
        $this->assertEquals(0b1, Flag::buildMask(0b1));
        $this->assertEquals(0b11, Flag::buildMask(0b01, 0b10));
        $this->assertEquals(0b11, Flag::buildMask(0b10, 0b01));
        $this->assertEquals(
            0b0011101101,
            Flag::buildMask(
                0b0010000000,
                0b0000000001,
                0b0001000000,
                0b0000001000,
                0b0000000100,
                0b0000100000
            )
        );
    }

    public function testMask()
    {
        $this->assertEquals(0b0, Flag::mask(0b1, 0b0));
        $this->assertEquals(0b0, Flag::mask(0b0, 0b1));

        $this->assertEquals(0b00, Flag::mask(0b00, 0b00));
        $this->assertEquals(0b00, Flag::mask(0b00, 0b01));
        $this->assertEquals(0b00, Flag::mask(0b00, 0b10));
        $this->assertEquals(0b00, Flag::mask(0b00, 0b11));

        $this->assertEquals(0b00, Flag::mask(0b01, 0b00));
        $this->assertEquals(0b01, Flag::mask(0b01, 0b01));
        $this->assertEquals(0b00, Flag::mask(0b01, 0b10));
        $this->assertEquals(0b01, Flag::mask(0b01, 0b11));

        $this->assertEquals(0b00, Flag::mask(0b10, 0b00));
        $this->assertEquals(0b00, Flag::mask(0b10, 0b01));
        $this->assertEquals(0b10, Flag::mask(0b10, 0b10));
        $this->assertEquals(0b10, Flag::mask(0b10, 0b11));

        $this->assertEquals(0b00, Flag::mask(0b11, 0b00));
        $this->assertEquals(0b01, Flag::mask(0b11, 0b01));
        $this->assertEquals(0b10, Flag::mask(0b11, 0b10));
        $this->assertEquals(0b11, Flag::mask(0b11, 0b11));
    }

    public function testMatchMask()
    {
        $this->assertTrue(Flag::matchMask(0b0, 0b0));
        $this->assertFalse(Flag::matchMask(0b0, 0b1));
        $this->assertTrue(Flag::matchMask(0b1, 0b0));
        $this->assertTrue(Flag::matchMask(0b1, 0b1));

        $this->assertTrue(Flag::matchMask(0b10, 0b10));
        $this->assertTrue(Flag::matchMask(0b11, 0b10));
        $this->assertFalse(Flag::matchMask(0b10, 0b01));

        $this->assertTrue(Flag::matchMask(0b11010, 0b10010));
        $this->assertFalse(Flag::matchMask(0b10010, 0b11010));
    }
}
