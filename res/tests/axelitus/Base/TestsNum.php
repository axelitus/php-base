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

use axelitus\Base\Num;

/**
 * Class TestsNumeric
 *
 * @package axelitus\Base
 */
class TestsNum extends TestCase
{
    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(Num::is(-5));
        $this->assertTrue(Num::is(0));
        $this->assertTrue(Num::is(5));
        $this->assertTrue(Num::is(-5.0));
        $this->assertTrue(Num::is(0.0));
        $this->assertTrue(Num::is(5.0));
        $this->assertFalse(Num::is('string'));
        $this->assertFalse(Num::is(true));
        $this->assertFalse(Num::is(false));
        $this->assertFalse(Num::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(Num::extIs(-5));
        $this->assertTrue(Num::extIs(0));
        $this->assertTrue(Num::extIs(5));
        $this->assertTrue(Num::extIs(-5.0));
        $this->assertTrue(Num::extIs(0.0));
        $this->assertTrue(Num::extIs(5.0));
        $this->assertTrue(Num::extIs('-5'));
        $this->assertTrue(Num::extIs('0'));
        $this->assertTrue(Num::extIs('5'));
        $this->assertFalse(Num::extIs('5th Street'));
        $this->assertTrue(Num::extIs('-5.0'));
        $this->assertTrue(Num::extIs('0.0'));
        $this->assertTrue(Num::extIs('5.0'));
        $this->assertFalse(Num::extIs('string'));
        $this->assertFalse(Num::extIs(true));
        $this->assertFalse(Num::extIs(false));
        $this->assertFalse(Num::extIs([]));
    }

    //endregion

    //region Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, Num::compare(10, 20));
        $this->assertLessThan(0, Num::compare(10, 20.5));
        $this->assertGreaterThan(0, Num::compare(30, 20));
        $this->assertGreaterThan(0, Num::compare(30.5, 20));
        $this->assertEquals(0, Num::compare(15, 15));
        $this->assertEquals(0, Num::compare(15.5, 15.5));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(Num::equals(10, 10));
        $this->assertTrue(Num::equals(10.5, 10.5));
        $this->assertFalse(Num::equals(-10, 10));
        $this->assertFalse(Num::equals(-10.5, 10.5));
        $this->assertFalse(Num::equals(10, -10));
        $this->assertFalse(Num::equals(10.5, -10.5));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(Num::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(Num::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(Num::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(Num::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(Num::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(Num::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(Num::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(Num::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(Num::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(Num::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(Num::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(Num::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(Num::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(Num::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = false;
        $range = [0, 1];
        $this->setExpectedException('\InvalidArgumentException', "The \$value, \$lower and \$upper parameters must be numeric.");
        Num::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [false, 1.5];
        $this->setExpectedException('\InvalidArgumentException', "The \$value, \$lower and \$upper parameters must be numeric.");
        Num::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, false];
        $this->setExpectedException('\InvalidArgumentException', "The \$value, \$lower and \$upper parameters must be numeric.");
        Num::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Num::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(Num::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(Num::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(Num::inside($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Num::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(Num::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(Num::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Num::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(Num::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(Num::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(Num::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(Num::between($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Num::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(Num::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(Num::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Num::between($value, $rangeD[0], $rangeD[1]));
    }

    //endregion
}
