<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.1
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
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
        Num::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [false, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
        Num::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, false];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
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

    //region Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, Num::add(3, 2));
        $this->assertEquals(-5, Num::add(-3, -2));
        $this->assertEquals(-1, Num::add(-3, 2));
        $this->assertEquals(5.75, Num::add(3.5, 2.25));
    }

    public function testAddEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::add(5, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::add(false, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, Num::sub(3, 2));
        $this->assertEquals(-1, Num::sub(-3, -2));
        $this->assertEquals(-5, Num::sub(-3, 2));
        $this->assertEquals(1.25, Num::sub(3.5, 2.25));
    }

    public function testSubEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::sub(5, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::sub(false, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, Num::mul(5, 5));
        $this->assertEquals(27, Num::mul(-9, -3));
        $this->assertEquals(-42, Num::mul(-7, 6));
        $this->assertEquals(28.875, Num::mul(5.5, 5.25));
    }

    public function testMulEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::mul(5, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::mul(false, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, Num::div(27, 9));
        $this->assertEquals(6, Num::div(42, 7));
        $this->assertEquals(2, Num::div(8, 4));
        $this->assertEquals(5.5, Num::div(23.375, 4.25));
    }

    public function testDivEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::div(5, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        Num::div(false, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$num2 parameter cannot be zero."
        );
        Num::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, Num::pow(5, 3));
        $this->assertEquals(-8, Num::pow(-2, 3));
        $this->assertEquals(15129, Num::pow(123, 2));
        $this->assertEquals(97.65625, Num::pow(2.5, 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric."
        );
        Num::pow(5, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric."
        );
        Num::pow(false, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, Num::mod(25, 5));
        $this->assertEquals(1, Num::mod(43, 3));
        $this->assertEquals(6, Num::mod(278, 8));
        $this->assertEquals(9.35, Num::mod(328.35, 11));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric."
        );
        Num::mod(5, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric."
        );
        Num::mod(false, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        Num::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, Num::sqrt(9));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be numeric.");
        Num::sqrt(false);
    }

    //endregion
}
