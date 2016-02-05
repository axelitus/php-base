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

use axelitus\Base\ABigInt;

/**
 * Class TestsABigInt
 *
 * @package axelitus\Base
 */
class TestsABigInt extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(ABigInt::is(-5));
        $this->assertTrue(ABigInt::is(0));
        $this->assertTrue(ABigInt::is(5));
        $this->assertTrue(ABigInt::is('-5'));
        $this->assertTrue(ABigInt::is('0'));
        $this->assertTrue(ABigInt::is('5'));
        $this->assertTrue(ABigInt::is('824357247439634062562562966721753589745973549'));
        $this->assertFalse(ABigInt::is(-5.0));
        $this->assertFalse(ABigInt::is(0.0));
        $this->assertFalse(ABigInt::is(5.0));
        $this->assertFalse(ABigInt::is('string'));
        $this->assertFalse(ABigInt::is(true));
        $this->assertFalse(ABigInt::is(false));
        $this->assertFalse(ABigInt::is([]));
    }

    public function testIsEven()
    {
        $this->assertTrue(ABigInt::isEven(-8));
        $this->assertTrue(ABigInt::isEven(0));
        $this->assertTrue(ABigInt::isEven(6));
        $this->assertFalse(ABigInt::isEven(-7));
        $this->assertFalse(ABigInt::isEven(5));

        $this->assertTrue(ABigInt::isEven('-8'));
        $this->assertTrue(ABigInt::isEven('0'));
        $this->assertTrue(ABigInt::isEven('6'));
        $this->assertFalse(ABigInt::isEven('-7'));
        $this->assertFalse(ABigInt::isEven('5'));
    }

    public function testIsEvenEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int (or string representing a big int)."
        );
        ABigInt::isEven(2.3);
    }

    public function testIsOdd()
    {
        $this->assertTrue(ABigInt::isOdd(-7));
        $this->assertTrue(ABigInt::isOdd(5));
        $this->assertFalse(ABigInt::isOdd(-8));
        $this->assertFalse(ABigInt::isOdd(0));
        $this->assertFalse(ABigInt::isOdd(6));

        $this->assertTrue(ABigInt::isOdd('-7'));
        $this->assertTrue(ABigInt::isOdd('5'));
        $this->assertFalse(ABigInt::isOdd('-8'));
        $this->assertFalse(ABigInt::isOdd('0'));
        $this->assertFalse(ABigInt::isOdd('6'));
    }

    public function testIsOddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int (or string representing a big int)."
        );
        ABigInt::isOdd(2.3);
    }

    // endregion

    // region: Conversion

    public function testToFloat()
    {
        $float = ABigInt::toFloat(5);
        $this->assertTrue(is_float($float));
        $this->assertEquals(5.0, $float);

        $strFloat = ABigInt::toFloat('5');
        $this->assertEquals('5.0', $strFloat);
    }

    public function testToIntEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int (or string representing a big int)."
        );
        ABigInt::toFloat(false);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, ABigInt::compare(10, 20));
        $this->assertGreaterThan(0, ABigInt::compare(30, 20));
        $this->assertEquals(0, ABigInt::compare(15, 15));

        $this->assertLessThan(0, ABigInt::compare('123456789098765432101234567890', '987654321012345678909876543210'));
        $this->assertGreaterThan(
            0,
            ABigInt::compare('987654321012345678909876543210', '123456789098765432101234567890')
        );
        $this->assertEquals(0, ABigInt::compare('123456789098765432101234567890', '123456789098765432101234567890'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(ABigInt::equals(10, 10));
        $this->assertFalse(ABigInt::equals(-10, 10));
        $this->assertFalse(ABigInt::equals(10, -10));

        $this->assertTrue(ABigInt::equals('123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(ABigInt::equals('-123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(ABigInt::equals('123456789098765432101234567890', '-123456789098765432101234567890'));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(ABigInt::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigInt::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigInt::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(ABigInt::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigInt::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigInt::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '123456789098765432101234567890';
        $rangeA = ['23456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigInt::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigInt::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigInt::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigInt::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(ABigInt::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigInt::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigInt::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigInt::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 0.5;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        ABigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        ABigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        ABigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigInt::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(ABigInt::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(ABigInt::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ABigInt::inside($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(ABigInt::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(ABigInt::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(ABigInt::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigInt::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(ABigInt::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(ABigInt::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(ABigInt::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(ABigInt::between($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(ABigInt::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertFalse(ABigInt::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertFalse(ABigInt::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(ABigInt::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Basic numeric operations

    public function testAbs()
    {
        $this->assertEquals(5, ABigInt::abs(5));
        $this->assertEquals(5, ABigInt::abs(-5));
        $this->assertEquals('5', ABigInt::abs('5'));
        $this->assertEquals('5', ABigInt::abs('-5'));
    }

    public function testAbsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int parameter must be of type int (or string representing a big int)."
        );
        ABigInt::abs(2.3);
    }

    public function testAdd()
    {
        $this->assertEquals(5, ABigInt::add(3, 2));
        $this->assertEquals(-5, ABigInt::add(-3, -2));
        $this->assertEquals(-1, ABigInt::add(-3, 2));

        $this->assertEquals('12345678909876543215', ABigInt::add('12345678909876543210', '5'));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::add(5, 2.3);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::add(3.4, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, ABigInt::sub(3, 2));
        $this->assertEquals(-1, ABigInt::sub(-3, -2));
        $this->assertEquals(-5, ABigInt::sub(-3, 2));

        $this->assertEquals('12345678909876543210', ABigInt::sub('12345678909876543215', '5'));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::sub(5, 2.3);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::sub(3.4, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, ABigInt::mul(5, 5));
        $this->assertEquals(27, ABigInt::mul(-9, -3));
        $this->assertEquals(-42, ABigInt::mul(-7, 6));

        $this->assertEquals('61728394549382716050', ABigInt::mul('12345678909876543210', '5'));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::mul(5, 2.3);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::mul(3.4, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, ABigInt::div(27, 9));
        $this->assertEquals(6, ABigInt::div(42, 7));
        $this->assertEquals(2, ABigInt::div(8, 4));

        $this->assertEquals('12345678909876543210', ABigInt::div('61728394549382716050', '5'));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::div(5, 2.3);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        ABigInt::div(3.4, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$int2 parameter cannot be zero."
        );
        ABigInt::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, ABigInt::pow(5, 3));
        $this->assertEquals(-8, ABigInt::pow(-2, 3));
        $this->assertEquals(15129, ABigInt::pow(123, 2));

        $this->assertEquals('152415787745770472322816643778997104100', ABigInt::pow('12345678909876543210', '2'));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type int (or string representing a big int)."
        );
        ABigInt::pow(5, 2.3);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type int (or string representing a big int)."
        );
        ABigInt::pow(3.4, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, ABigInt::mod(25, 5));
        $this->assertEquals(1, ABigInt::mod(43, 3));
        $this->assertEquals(6, ABigInt::mod(278, 8));

        $this->assertEquals('0', ABigInt::mod('61728394549382716050', '12345678909876543210'));
        $this->assertEquals('822222222210', ABigInt::mod('98765432101234567890', '12345678909876543210'));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type int (or string representing a big int)."
        );
        ABigInt::mod(5, 2.3);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type int (or string representing a big int)."
        );
        ABigInt::mod(3.4, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        ABigInt::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, ABigInt::sqrt(9));

        $this->assertEquals('12345678909876543210', ABigInt::sqrt('152415787745770472322816643778997104100'));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base parameters must be of type int (or string representing a big int)."
        );
        ABigInt::sqrt(2.3);
    }

    // endregion
}
