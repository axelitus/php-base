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

use axelitus\Base\ABigNum;

/**
 * Class TestsABigNum
 *
 * @package axelitus\Base
 */
class TestsABigNum extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(ABigNum::is(-5));
        $this->assertTrue(ABigNum::is(0));
        $this->assertTrue(ABigNum::is(5));
        $this->assertTrue(ABigNum::is('-5'));
        $this->assertTrue(ABigNum::is('0'));
        $this->assertTrue(ABigNum::is('5'));
        $this->assertTrue(ABigNum::is('824357247439634062562562966721753589745973549'));
        $this->assertTrue(ABigNum::is(-5.5));
        $this->assertTrue(ABigNum::is(0.5));
        $this->assertTrue(ABigNum::is(5.5));
        $this->assertTrue(ABigNum::is('-5.5'));
        $this->assertTrue(ABigNum::is('0.5'));
        $this->assertTrue(ABigNum::is('5.5'));
        $this->assertFalse(ABigNum::is('string'));
        $this->assertFalse(ABigNum::is(true));
        $this->assertFalse(ABigNum::is(false));
        $this->assertFalse(ABigNum::is([]));
    }

    // endregion

    // region: Conversion

    public function testToInt()
    {
        $this->assertEquals(9, ABigNum::toInt(9));
        $this->assertEquals('9', ABigNum::toInt('9'));
        $this->assertEquals(5, ABigNum::toInt(5.53623544));
        $this->assertEquals('5', ABigNum::toInt('5.53623544'));
    }

    public function testToIntEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be numeric (or string representing a big number)."
        );
        ABigNum::toInt(false);
    }

    public function testToFloat()
    {
        $float = ABigNum::toFloat(5);
        $this->assertTrue(is_float($float));
        $this->assertEquals(5.0, $float);

        $strFloat = ABigNum::toFloat('5');
        $this->assertEquals('5.0', $strFloat);
    }

    public function testToFloatEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be numeric (or string representing a big number)."
        );
        ABigNum::toFloat(false);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, ABigNum::compare(10, 20));
        $this->assertGreaterThan(0, ABigNum::compare(30, 20));
        $this->assertEquals(0, ABigNum::compare(15, 15));

        $this->assertLessThan(0, ABigNum::compare('123456789098765432101234567890', '987654321012345678909876543210'));
        $this->assertGreaterThan(
            0,
            ABigNum::compare('987654321012345678909876543210', '123456789098765432101234567890')
        );
        $this->assertEquals(0, ABigNum::compare('123456789098765432101234567890', '123456789098765432101234567890'));

        $this->assertLessThan(0, ABigNum::compare(10.5, 20.5));
        $this->assertGreaterThan(0, ABigNum::compare(30.5, 20.5));
        $this->assertEquals(0, ABigNum::compare(15.5, 15.5));

        $this->assertLessThan(0, ABigNum::compare('10.5', 20.5));
        $this->assertGreaterThan(0, ABigNum::compare(30.5, '20.5'));
        $this->assertEquals(0, ABigNum::compare('15.5', '15.5'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(ABigNum::equals(10, 10));
        $this->assertFalse(ABigNum::equals(-10, 10));
        $this->assertFalse(ABigNum::equals(10, -10));

        $this->assertTrue(ABigNum::equals('123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(ABigNum::equals('-123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(ABigNum::equals('123456789098765432101234567890', '-123456789098765432101234567890'));

        $this->assertTrue(ABigNum::equals(10.5, 10.5));
        $this->assertFalse(ABigNum::equals(-10.5, 10.5));
        $this->assertFalse(ABigNum::equals(10.5, -10.5));

        $this->assertTrue(ABigNum::equals('10.5', 10.5));
        $this->assertFalse(ABigNum::equals(-10.5, '10.5'));
        $this->assertFalse(ABigNum::equals('10.5', '-10.5'));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '123456789098765432101234567890';
        $rangeA = ['23456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = false;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        ABigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [false, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        ABigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, false];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        ABigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(ABigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(ABigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ABigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(ABigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(ABigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ABigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ABigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(ABigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(ABigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigNum::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(ABigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(ABigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ABigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(ABigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertFalse(ABigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertFalse(ABigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(ABigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(ABigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertFalse(ABigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertFalse(ABigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigNum::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, ABigNum::add(3, 2));
        $this->assertEquals(-5, ABigNum::add(-3, -2));
        $this->assertEquals(-1, ABigNum::add(-3, 2));

        $this->assertEquals('12345678909876543215', ABigNum::add('12345678909876543210', '5'));

        $this->assertEquals(5.75, ABigNum::add(3.5, 2.25));
        $this->assertEquals('5.75', ABigNum::add('3.5', '2.25', 5));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::add(5, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::add(false, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, ABigNum::sub(3, 2));
        $this->assertEquals(-1, ABigNum::sub(-3, -2));
        $this->assertEquals(-5, ABigNum::sub(-3, 2));

        $this->assertEquals('12345678909876543210', ABigNum::sub('12345678909876543215', '5'));

        $this->assertEquals(1.25, ABigNum::sub(3.5, 2.25));
        $this->assertEquals('1.25', ABigNum::sub('3.5', '2.25', 5));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::sub(5, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::sub(false, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, ABigNum::mul(5, 5));
        $this->assertEquals(27, ABigNum::mul(-9, -3));
        $this->assertEquals(-42, ABigNum::mul(-7, 6));

        $this->assertEquals('61728394549382716050', ABigNum::mul('12345678909876543210', '5'));

        $this->assertEquals(28.875, ABigNum::mul(5.5, 5.25));
        $this->assertEquals('28.875', ABigNum::mul('5.5', '5.25', 5));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::mul(5, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::mul(false, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, ABigNum::div(27, 9));
        $this->assertEquals(6, ABigNum::div(42, 7));
        $this->assertEquals(2, ABigNum::div(8, 4));

        $this->assertEquals('12345678909876543210', ABigNum::div('61728394549382716050', '5'));

        $this->assertEquals(5.5, ABigNum::div(23.375, 4.25));
        $this->assertEquals('5.5', ABigNum::div('23.375', '4.25', 5));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::div(5, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        ABigNum::div(false, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$num2 parameter cannot be zero."
        );
        ABigNum::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, ABigNum::pow(5, 3));
        $this->assertEquals(-8, ABigNum::pow(-2, 3));
        $this->assertEquals(15129, ABigNum::pow(123, 2));

        $this->assertEquals('152415787745770472322816643778997104100', ABigNum::pow('12345678909876543210', '2'));

        $this->assertEquals(97.65625, ABigNum::pow(2.5, 5.0));
        $this->assertEquals('97.65625', ABigNum::pow('2.5', '5.0', 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric (or string representing a big number)."
        );
        ABigNum::pow(5, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric (or string representing a big number)."
        );
        ABigNum::pow(false, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, ABigNum::mod(25, 5));
        $this->assertEquals(1, ABigNum::mod(43, 3));
        $this->assertEquals(6, ABigNum::mod(278, 8));

        $this->assertEquals('0', ABigNum::mod('61728394549382716050', '12345678909876543210'));
        $this->assertEquals('822222222210', ABigNum::mod('98765432101234567890', '12345678909876543210'));

        $this->assertEquals(9.35, ABigNum::mod(328.35, 11.0));
        $this->assertEquals('9.35', ABigNum::mod('328.35', '11.0', 5));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric (or string representing a big number)."
        );
        ABigNum::mod(5, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric (or string representing a big number)."
        );
        ABigNum::mod(false, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        ABigNum::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, ABigNum::sqrt(9));

        $this->assertEquals('12345678909876543210', ABigNum::sqrt('152415787745770472322816643778997104100'));

        $this->assertEquals(3.0, ABigNum::sqrt(9.0));
        $this->assertEquals('3.0', ABigNum::sqrt('9.0', 5));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base parameters must be numeric (or string representing a big number)."
        );
        ABigNum::sqrt(false);
    }

    // endregion
}
