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

use axelitus\Base\BigNum;

/**
 * Class TestsBigNum
 *
 * @package axelitus\Base
 */
class TestsBigNum extends TestCase
{
    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(BigNum::is(-5));
        $this->assertTrue(BigNum::is(0));
        $this->assertTrue(BigNum::is(5));
        $this->assertTrue(BigNum::is('-5'));
        $this->assertTrue(BigNum::is('0'));
        $this->assertTrue(BigNum::is('5'));
        $this->assertTrue(BigNum::is('824357247439634062562562966721753589745973549'));
        $this->assertTrue(BigNum::is(-5.5));
        $this->assertTrue(BigNum::is(0.5));
        $this->assertTrue(BigNum::is(5.5));
        $this->assertTrue(BigNum::is('-5.5'));
        $this->assertTrue(BigNum::is('0.5'));
        $this->assertTrue(BigNum::is('5.5'));
        $this->assertFalse(BigNum::is('string'));
        $this->assertFalse(BigNum::is(true));
        $this->assertFalse(BigNum::is(false));
        $this->assertFalse(BigNum::is([]));
    }

    //endregion

    //region Conversion

    public function testInt()
    {
        $this->assertEquals(5, BigNum::int(5.53623544));
        $this->assertEquals('5', BigNum::int('5.53623544'));
    }

    public function testIntEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be numeric (or string representing a big number)."
        );
        BigNum::int(false);
    }

    //endregion

    //region Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, BigNum::compare(10, 20));
        $this->assertGreaterThan(0, BigNum::compare(30, 20));
        $this->assertEquals(0, BigNum::compare(15, 15));

        $this->assertLessThan(0, BigNum::compare('123456789098765432101234567890', '987654321012345678909876543210'));
        $this->assertGreaterThan(
            0,
            BigNum::compare('987654321012345678909876543210', '123456789098765432101234567890')
        );
        $this->assertEquals(0, BigNum::compare('123456789098765432101234567890', '123456789098765432101234567890'));

        $this->assertLessThan(0, BigNum::compare(10.5, 20.5));
        $this->assertGreaterThan(0, BigNum::compare(30.5, 20.5));
        $this->assertEquals(0, BigNum::compare(15.5, 15.5));

        $this->assertLessThan(0, BigNum::compare('10.5', 20.5));
        $this->assertGreaterThan(0, BigNum::compare(30.5, '20.5'));
        $this->assertEquals(0, BigNum::compare('15.5', '15.5'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(BigNum::equals(10, 10));
        $this->assertFalse(BigNum::equals(-10, 10));
        $this->assertFalse(BigNum::equals(10, -10));

        $this->assertTrue(BigNum::equals('123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(BigNum::equals('-123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(BigNum::equals('123456789098765432101234567890', '-123456789098765432101234567890'));

        $this->assertTrue(BigNum::equals(10.5, 10.5));
        $this->assertFalse(BigNum::equals(-10.5, 10.5));
        $this->assertFalse(BigNum::equals(10.5, -10.5));

        $this->assertTrue(BigNum::equals('10.5', 10.5));
        $this->assertFalse(BigNum::equals(-10.5, '10.5'));
        $this->assertFalse(BigNum::equals('10.5', '-10.5'));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '123456789098765432101234567890';
        $rangeA = ['23456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigNum::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigNum::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigNum::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigNum::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = false;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        BigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [false, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        BigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, false];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be numeric (or string representing a big number)."
        );
        BigNum::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(BigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(BigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(BigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(BigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(BigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(BigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(BigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigNum::inside($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigNum::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(BigNum::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(BigNum::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigNum::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(BigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(BigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(BigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(BigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertFalse(BigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertFalse(BigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(BigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(BigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigNum::between($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigNum::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertFalse(BigNum::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertFalse(BigNum::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigNum::between($value, $rangeD[0], $rangeD[1]));
    }

    //endregion

    //region Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, BigNum::add(3, 2));
        $this->assertEquals(-5, BigNum::add(-3, -2));
        $this->assertEquals(-1, BigNum::add(-3, 2));

        $this->assertEquals('12345678909876543215', BigNum::add('12345678909876543210', '5'));

        $this->assertEquals(5.75, BigNum::add(3.5, 2.25));
        $this->assertEquals('5.75', BigNum::add('3.5', '2.25', 5));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::add(5, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::add(false, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, BigNum::sub(3, 2));
        $this->assertEquals(-1, BigNum::sub(-3, -2));
        $this->assertEquals(-5, BigNum::sub(-3, 2));

        $this->assertEquals('12345678909876543210', BigNum::sub('12345678909876543215', '5'));

        $this->assertEquals(1.25, BigNum::sub(3.5, 2.25));
        $this->assertEquals('1.25', BigNum::sub('3.5', '2.25', 5));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::sub(5, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::sub(false, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, BigNum::mul(5, 5));
        $this->assertEquals(27, BigNum::mul(-9, -3));
        $this->assertEquals(-42, BigNum::mul(-7, 6));

        $this->assertEquals('61728394549382716050', BigNum::mul('12345678909876543210', '5'));

        $this->assertEquals(28.875, BigNum::mul(5.5, 5.25));
        $this->assertEquals('28.875', BigNum::mul('5.5', '5.25', 5));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::mul(5, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::mul(false, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, BigNum::div(27, 9));
        $this->assertEquals(6, BigNum::div(42, 7));
        $this->assertEquals(2, BigNum::div(8, 4));

        $this->assertEquals('12345678909876543210', BigNum::div('61728394549382716050', '5'));

        $this->assertEquals(5.5, BigNum::div(23.375, 4.25));
        $this->assertEquals('5.5', BigNum::div('23.375', '4.25', 5));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::div(5, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$num1 and \$num2 parameters must be numeric (or string representing a big number)."
        );
        BigNum::div(false, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$num2 parameter cannot be zero."
        );
        BigNum::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, BigNum::pow(5, 3));
        $this->assertEquals(-8, BigNum::pow(-2, 3));
        $this->assertEquals(15129, BigNum::pow(123, 2));

        $this->assertEquals('152415787745770472322816643778997104100', BigNum::pow('12345678909876543210', '2'));

        $this->assertEquals(97.65625, BigNum::pow(2.5, 5.0));
        $this->assertEquals('97.65625', BigNum::pow('2.5', '5.0', 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric (or string representing a big number)."
        );
        BigNum::pow(5, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be numeric (or string representing a big number)."
        );
        BigNum::pow(false, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, BigNum::mod(25, 5));
        $this->assertEquals(1, BigNum::mod(43, 3));
        $this->assertEquals(6, BigNum::mod(278, 8));

        $this->assertEquals('0', BigNum::mod('61728394549382716050', '12345678909876543210'));
        $this->assertEquals('822222222210', BigNum::mod('98765432101234567890', '12345678909876543210'));

        $this->assertEquals(9.35, BigNum::mod(328.35, 11.0));
        $this->assertEquals('9.35', BigNum::mod('328.35', '11.0', 5));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric (or string representing a big number)."
        );
        BigNum::mod(5, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be numeric (or string representing a big number)."
        );
        BigNum::mod(false, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        BigNum::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, BigNum::sqrt(9));

        $this->assertEquals('12345678909876543210', BigNum::sqrt('152415787745770472322816643778997104100'));

        $this->assertEquals(3.0, BigNum::sqrt(9.0));
        $this->assertEquals('3.0', BigNum::sqrt('9.0', 5));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base parameters must be numeric (or string representing a big number)."
        );
        BigNum::sqrt(false);
    }

    //endregion
}
