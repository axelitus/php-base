<?php
/**
 * axelitus/base - Primitive extensions and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.4
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Int;

/**
 * Class TestsInt
 *
 * @package axelitus\Base
 */
class TestsInt extends TestCase
{
    /**
     * Tests Int::is()
     */
    public function test_isInt()
    {
        $this->assertTrue(Int::is(0), "The value 0 is not recognized as an int.");
        $this->assertTrue(Int::is(5), "The value 5 is not recognized as an int.");
        $this->assertTrue(Int::is(-23), "The value -23 is not recognized as an int.");
        $this->assertTrue(Int::is(0.0), "The value 0.0 is not recognized as an int.");
        $this->assertTrue(Int::is(7.0), "The value 7.0 is not recognized as an int.");
        $this->assertTrue(Int::is(-23.0), "The value -23.0 is not recognized as an int.");
        $this->assertTrue(Int::is("65"), "The value \"65\" is not recognized as an int.");
        $this->assertFalse(Int::is(5.23), "The value 5.0 is incorrectly recognized as an int.");
        $this->assertFalse(Int::is(-4.9), "The value -4.9 is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("string"), "The value \"string\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("2. string"), "The value \"2. string\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("7. string 9"), "The value \"7. string 9\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("string 4"), "The value \"string 4\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is([]), "The value [] is incorrectly recognized as an int.");
    }

    /**
     * Tests Int::random()
     */
    public function test_random()
    {
        $rand = Int::random();
        $output = ($rand >= 0 and $rand <= 1);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(5, 10);
        $output = ($rand >= 5 and $rand <= 10);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(-20, 0);
        $output = ($rand >= -20 and $rand <= 0);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(150, 250, 10);
        $output = ($rand >= 150 and $rand <= 250);
        $this->assertTrue(is_int($rand) and $output);
        $this->assertEquals(173, $rand);    // Because it's seeded it should give us the same result

        $this->setExpectedException('\InvalidArgumentException');
        Int::random(false);

        $this->setExpectedException('\InvalidArgumentException');
        Int::random(6, false);
    }

    /**
     * Tests Int::inRange()
     */
    public function test_inRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Int::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(Int::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(Int::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(Int::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(Int::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(Int::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(Int::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(Int::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(Int::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(Int::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(Int::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(Int::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(Int::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(Int::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(Int::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(Int::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    /**
     * Tests Int::inside()
     * @depends test_inRange
     */
    public function test_inside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Int::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(Int::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(Int::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(Int::inside($value, $rangeD[0], $rangeD[1]));
    }

    /**
     * Tests Int::between()
     * @depends test_inRange
     */
    public function test_between()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Int::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(Int::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(Int::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(Int::between($value, $rangeD[0], $rangeD[1]));
    }

    /**
     * Tests Int::inRange()
     */
    public function test_inRangeException01()
    {
        $value = 0.5;
        $range = [0, 1];
        $this->setExpectedException('\InvalidArgumentException');
        Int::inRange($value, $range[0], $range[1]);
    }

    /**
     * Tests Int::inRange()
     */
    public function test_inRangeException02()
    {
        $value = 1;
        $range = [0.5, 1];
        $this->setExpectedException('\InvalidArgumentException');
        Int::inRange($value, $range[0], $range[1]);
    }

    /**
     * Tests Int::inRange()
     */
    public function test_inRangeException03()
    {
        $value = 1;
        $range = [0, 1.5];
        $this->setExpectedException('\InvalidArgumentException');
        Int::inRange($value, $range[0], $range[1]);
    }
}
