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

use axelitus\Base\ANum;

/**
 * Class TestsANum
 *
 * @package axelitus\Base
 */
class TestsANum extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(ANum::is(-5));
        $this->assertTrue(ANum::is(0));
        $this->assertTrue(ANum::is(5));
        $this->assertTrue(ANum::is(-5.0));
        $this->assertTrue(ANum::is(0.0));
        $this->assertTrue(ANum::is(5.0));
        $this->assertFalse(ANum::is('string'));
        $this->assertFalse(ANum::is(true));
        $this->assertFalse(ANum::is(false));
        $this->assertFalse(ANum::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(ANum::extIs(-5));
        $this->assertTrue(ANum::extIs(0));
        $this->assertTrue(ANum::extIs(5));
        $this->assertTrue(ANum::extIs(-5.0));
        $this->assertTrue(ANum::extIs(0.0));
        $this->assertTrue(ANum::extIs(5.0));
        $this->assertTrue(ANum::extIs('-5'));
        $this->assertTrue(ANum::extIs('0'));
        $this->assertTrue(ANum::extIs('5'));
        $this->assertFalse(ANum::extIs('5th Street'));
        $this->assertTrue(ANum::extIs('-5.0'));
        $this->assertTrue(ANum::extIs('0.0'));
        $this->assertTrue(ANum::extIs('5.0'));
        $this->assertFalse(ANum::extIs('string'));
        $this->assertFalse(ANum::extIs(true));
        $this->assertFalse(ANum::extIs(false));
        $this->assertFalse(ANum::extIs([]));
    }

    // endregion

    // region: Conversion

    public function testParse()
    {
        $int = ANum::parse('5');
        $this->assertEquals(5, $int);
        $this->assertTrue(is_int($int));

        $float = ANum::parse('5.0');
        $this->assertEquals(5.0, $float);
        $this->assertTrue(is_float($float));

        $this->assertEquals(null, ANum::parse('string'));
        $this->assertEquals('default', ANum::parse('string', 'default'));
        $this->assertEquals('default', ANum::parse('string', 'default'));
    }

    public function testToInt()
    {
        $int = ANum::toInt(5);
        $this->assertEquals(5, $int);
        $this->assertTrue(is_int($int));

        $int = ANum::toInt(5.0);
        $this->assertEquals(5, $int);
        $this->assertTrue(is_int($int));
    }

    public function testToIntEx01()
    {
        $this->setExpectedException('\InvalidArgumentException',
            "The \$value parameter must be numeric."
        );
        ANum::toInt(false);
    }

    public function testToFloat()
    {
        $float = ANum::toFloat(5);
        $this->assertEquals(5.0, $float);
        $this->assertTrue(is_float($float));

        $float = ANum::toFloat(5.0);
        $this->assertEquals(5.0, $float);
        $this->assertTrue(is_float($float));
    }

    public function testToFloatEx01()
    {
        $this->setExpectedException('\InvalidArgumentException',
            "The \$value parameter must be numeric."
        );
        ANum::toFloat(false);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, ANum::compare(10, 20));
        $this->assertLessThan(0, ANum::compare(10, 20.5));
        $this->assertGreaterThan(0, ANum::compare(30, 20));
        $this->assertGreaterThan(0, ANum::compare(30.5, 20));
        $this->assertEquals(0, ANum::compare(15, 15));
        $this->assertEquals(0, ANum::compare(15.5, 15.5));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(ANum::equals(10, 10));
        $this->assertTrue(ANum::equals(10.5, 10.5));
        $this->assertFalse(ANum::equals(-10, 10));
        $this->assertFalse(ANum::equals(-10.5, 10.5));
        $this->assertFalse(ANum::equals(10, -10));
        $this->assertFalse(ANum::equals(10.5, -10.5));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(ANum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ANum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ANum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(ANum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ANum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ANum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ANum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ANum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ANum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ANum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ANum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ANum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ANum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ANum::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = false;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
        ANum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [false, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
        ANum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, false];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric."
        );
        ANum::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ANum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(ANum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(ANum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ANum::inside($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ANum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ANum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ANum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ANum::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ANum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(ANum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(ANum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ANum::between($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ANum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(ANum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(ANum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ANum::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, ANum::add(3, 2));
        $this->assertEquals(-5, ANum::add(-3, -2));
        $this->assertEquals(-1, ANum::add(-3, 2));
        $this->assertEquals(5.75, ANum::add(3.5, 2.25));
    }

    public function testAddEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::add(5, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::add(false, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, ANum::sub(3, 2));
        $this->assertEquals(-1, ANum::sub(-3, -2));
        $this->assertEquals(-5, ANum::sub(-3, 2));
        $this->assertEquals(1.25, ANum::sub(3.5, 2.25));
    }

    public function testSubEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::sub(5, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::sub(false, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, ANum::mul(5, 5));
        $this->assertEquals(27, ANum::mul(-9, -3));
        $this->assertEquals(-42, ANum::mul(-7, 6));
        $this->assertEquals(28.875, ANum::mul(5.5, 5.25));
    }

    public function testMulEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::mul(5, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::mul(false, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, ANum::div(27, 9));
        $this->assertEquals(6, ANum::div(42, 7));
        $this->assertEquals(2, ANum::div(8, 4));
        $this->assertEquals(5.5, ANum::div(23.375, 4.25));
    }

    public function testDivEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::div(5, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$num1 and \$num2 parameters must be numeric.");
        ANum::div(false, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$num2 parameter cannot be zero."
        );
        ANum::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, ANum::pow(5, 3));
        $this->assertEquals(-8, ANum::pow(-2, 3));
        $this->assertEquals(15129, ANum::pow(123, 2));
        $this->assertEquals(97.65625, ANum::pow(2.5, 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric."
        );
        ANum::pow(5, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric."
        );
        ANum::pow(false, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, ANum::mod(25, 5));
        $this->assertEquals(1, ANum::mod(43, 3));
        $this->assertEquals(6, ANum::mod(278, 8));
        $this->assertEquals(9.35, ANum::mod(328.35, 11));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric."
        );
        ANum::mod(5, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric."
        );
        ANum::mod(false, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        ANum::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, ANum::sqrt(9));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be numeric.");
        ANum::sqrt(false);
    }

    // endregion
}
