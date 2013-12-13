<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.5
 */

namespace axelitus\Base\Tests;

use axelitus\Base\BigInt;

/**
 * Class TestsBigInt
 *
 * @package axelitus\Base
 */
class TestsBigInt extends TestCase
{
    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(BigInt::is(-5));
        $this->assertTrue(BigInt::is(0));
        $this->assertTrue(BigInt::is(5));
        $this->assertTrue(BigInt::is('-5'));
        $this->assertTrue(BigInt::is('0'));
        $this->assertTrue(BigInt::is('5'));
        $this->assertTrue(BigInt::is('824357247439634062562562966721753589745973549'));
        $this->assertFalse(BigInt::is(-5.0));
        $this->assertFalse(BigInt::is(0.0));
        $this->assertFalse(BigInt::is(5.0));
        $this->assertFalse(BigInt::is('string'));
        $this->assertFalse(BigInt::is(true));
        $this->assertFalse(BigInt::is(false));
        $this->assertFalse(BigInt::is([]));
    }

    //endregion

    //region Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, BigInt::compare(10, 20));
        $this->assertGreaterThan(0, BigInt::compare(30, 20));
        $this->assertEquals(0, BigInt::compare(15, 15));

        $this->assertLessThan(0, BigInt::compare('123456789098765432101234567890', '987654321012345678909876543210'));
        $this->assertGreaterThan(0, BigInt::compare('987654321012345678909876543210', '123456789098765432101234567890'));
        $this->assertEquals(0, BigInt::compare('123456789098765432101234567890', '123456789098765432101234567890'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        BigInt::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int (or string representing a big int)."
        );
        BigInt::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(BigInt::equals(10, 10));
        $this->assertFalse(BigInt::equals(-10, 10));
        $this->assertFalse(BigInt::equals(10, -10));

        $this->assertTrue(BigInt::equals('123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(BigInt::equals('-123456789098765432101234567890', '123456789098765432101234567890'));
        $this->assertFalse(BigInt::equals('123456789098765432101234567890', '-123456789098765432101234567890'));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(BigInt::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigInt::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigInt::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(BigInt::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigInt::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigInt::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '123456789098765432101234567890';
        $rangeA = ['23456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigInt::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigInt::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigInt::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigInt::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(BigInt::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigInt::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigInt::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigInt::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 0.5;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        BigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        BigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int (or string representing a big int)."
        );
        BigInt::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigInt::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(BigInt::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(BigInt::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(BigInt::inside($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(BigInt::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertTrue(BigInt::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertTrue(BigInt::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigInt::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(BigInt::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(BigInt::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(BigInt::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(BigInt::between($value, $rangeD[0], $rangeD[1]));

        $value = '123456789098765432101234567890';
        $rangeA = ['0', '987654321012345678909876543210'];
        $this->assertTrue(BigInt::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['123456789098765432101234567890', '987654321012345678909876543210'];
        $this->assertFalse(BigInt::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0', '123456789098765432101234567890'];
        $this->assertFalse(BigInt::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['987654321012345678909876543210', '9999987654321012345678909876543210'];
        $this->assertFalse(BigInt::between($value, $rangeD[0], $rangeD[1]));
    }

    //endregion

    //region Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, BigInt::add(3, 2));
        $this->assertEquals(-5, BigInt::add(-3, -2));
        $this->assertEquals(-1, BigInt::add(-3, 2));

        $this->assertEquals('12345678909876543215', BigInt::add('12345678909876543210', '5'));
    }

    public function testAddEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::add(5, 2.3);
    }

    public function testAddEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::add(3.4, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, BigInt::sub(3, 2));
        $this->assertEquals(-1, BigInt::sub(-3, -2));
        $this->assertEquals(-5, BigInt::sub(-3, 2));

        $this->assertEquals('12345678909876543210', BigInt::sub('12345678909876543215', '5'));
    }

    public function testSubEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::sub(5, 2.3);
    }

    public function testSubEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::sub(3.4, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, BigInt::mul(5, 5));
        $this->assertEquals(27, BigInt::mul(-9, -3));
        $this->assertEquals(-42, BigInt::mul(-7, 6));

        $this->assertEquals('61728394549382716050', BigInt::mul('12345678909876543210', '5'));
    }

    public function testMulEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::mul(5, 2.3);
    }

    public function testMulEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::mul(3.4, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, BigInt::div(27, 9));
        $this->assertEquals(6, BigInt::div(42, 7));
        $this->assertEquals(2, BigInt::div(8, 4));

        $this->assertEquals('12345678909876543210', BigInt::div('61728394549382716050', '5'));
    }

    public function testDivEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::div(5, 2.3);
    }

    public function testDivEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int (or string representing a big int).");
        BigInt::div(3.4, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$int2 parameter cannot be zero."
        );
        BigInt::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, BigInt::pow(5, 3));
        $this->assertEquals(-8, BigInt::pow(-2, 3));
        $this->assertEquals(15129, BigInt::pow(123, 2));

        $this->assertEquals('152415787745770472322816643778997104100', BigInt::pow('12345678909876543210', '2'));
    }

    public function testPowEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be int (or string representing a big int).");
        BigInt::pow(5, 2.3);
    }

    public function testPowEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be int (or string representing a big int).");
        BigInt::pow(3.4, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, BigInt::mod(25, 5));
        $this->assertEquals(1, BigInt::mod(43, 3));
        $this->assertEquals(6, BigInt::mod(278, 8));

        $this->assertEquals('0', BigInt::mod('61728394549382716050', '12345678909876543210'));
        $this->assertEquals('822222222210', BigInt::mod('98765432101234567890', '12345678909876543210'));
    }

    public function testModEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be int (or string representing a big int).");
        BigInt::mod(5, 2.3);
    }

    public function testModEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be int (or string representing a big int).");
        BigInt::mod(3.4, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        BigInt::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, BigInt::sqrt(9));

        $this->assertEquals('12345678909876543210', BigInt::sqrt('152415787745770472322816643778997104100'));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be int (or string representing a big int).");
        BigInt::sqrt(2.3);
    }

    //endregion
}
