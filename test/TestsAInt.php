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

use axelitus\Base\AInt;

/**
 * Class TestsAInt
 *
 * @package axelitus\Base
 */
class TestsAInt extends TestCase
{
    // region: Constants

    public function testConstants()
    {
        $this->assertEquals(PHP_INT_MAX, AInt::MAX);
    }

    // endregion

    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(AInt::is(-5));
        $this->assertTrue(AInt::is(0));
        $this->assertTrue(AInt::is(5));
        $this->assertFalse(AInt::is(-5.0));
        $this->assertFalse(AInt::is(0.0));
        $this->assertFalse(AInt::is(5.0));
        $this->assertFalse(AInt::is('string'));
        $this->assertFalse(AInt::is(true));
        $this->assertFalse(AInt::is(false));
        $this->assertFalse(AInt::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(AInt::extIs(-5));
        $this->assertTrue(AInt::extIs(0));
        $this->assertTrue(AInt::extIs(5));
        $this->assertFalse(AInt::extIs(-5.0));
        $this->assertFalse(AInt::extIs(0.0));
        $this->assertFalse(AInt::extIs(5.0));
        $this->assertTrue(AInt::extIs('-5'));
        $this->assertTrue(AInt::extIs('0'));
        $this->assertTrue(AInt::extIs('5'));
        $this->assertFalse(AInt::extIs('5th Street'));
        $this->assertFalse(AInt::extIs('-5.0'));
        $this->assertFalse(AInt::extIs('0.0'));
        $this->assertFalse(AInt::extIs('5.0'));
        $this->assertFalse(AInt::extIs('string'));
        $this->assertFalse(AInt::extIs(true));
        $this->assertFalse(AInt::extIs(false));
        $this->assertFalse(AInt::extIs([]));
    }

    public function testIsEven()
    {
        $this->assertTrue(AInt::isEven(-8));
        $this->assertTrue(AInt::isEven(0));
        $this->assertTrue(AInt::isEven(6));
        $this->assertFalse(AInt::isEven(-7));
        $this->assertFalse(AInt::isEven(5));
    }

    public function testIsEvenEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        AInt::isEven(2.3);
    }

    public function testIsOdd()
    {
        $this->assertTrue(AInt::isOdd(-7));
        $this->assertTrue(AInt::isOdd(5));
        $this->assertFalse(AInt::isOdd(-8));
        $this->assertFalse(AInt::isOdd(0));
        $this->assertFalse(AInt::isOdd(6));
    }

    public function testIsOddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        AInt::isOdd(2.3);
    }

    // endregion

    // region: Conversion

    public function testParse()
    {
        $this->assertEquals(5, AInt::parse('5'));
        $this->assertEquals(9, AInt::parse('9'));
        $this->assertEquals(5, AInt::parse('5.0'));

        $this->assertEquals(null, AInt::parse('string'));
        $this->assertEquals(5, AInt::parse('string', 5));
        $this->assertEquals(9, AInt::parse('string', 9));
    }

    public function testToFloat()
    {
        $float = AInt::toFloat(5);
        $this->assertEquals(5.0, $float);
        $this->assertTrue(is_float($float));
    }

    public function testToFloatEx01()
    {
        $this->setExpectedException('\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        AInt::toFloat(5.0);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, AInt::compare(10, 20));
        $this->assertGreaterThan(0, AInt::compare(30, 20));
        $this->assertEquals(0, AInt::compare(15, 15));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(AInt::equals(10, 10));
        $this->assertFalse(AInt::equals(-10, 10));
        $this->assertFalse(AInt::equals(10, -10));
    }

    public function testInRange()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(AInt::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(AInt::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(AInt::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(AInt::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3, 9];
        $this->assertTrue(AInt::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(AInt::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(AInt::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(AInt::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0, 3];
        $this->assertTrue(AInt::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(AInt::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(AInt::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(AInt::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5, 9];
        $this->assertFalse(AInt::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(AInt::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(AInt::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(AInt::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 0.5;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        AInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        AInt::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        AInt::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(AInt::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertTrue(AInt::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertTrue(AInt::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(AInt::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3;
        $rangeA = [0, 5];
        $this->assertTrue(AInt::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3, 9];
        $this->assertFalse(AInt::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0, 3];
        $this->assertFalse(AInt::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5, 9];
        $this->assertFalse(AInt::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Random

    public function testRandom()
    {
        $rand = AInt::random();
        $output = ($rand >= 0 && $rand <= 1);
        $this->assertTrue(is_int($rand) && $output);

        $rand = AInt::random(5, 10);
        $output = ($rand >= 5 && $rand <= 10);
        $this->assertTrue(is_int($rand) && $output);

        $rand = AInt::random(-20, 0);
        $output = ($rand >= -20 && $rand <= 0);
        $this->assertTrue(is_int($rand) && $output);

        $rand = AInt::random(150, 250, 10);
        $output = ($rand >= 150 && $rand <= 250);
        $this->assertTrue(is_int($rand) && $output);
        $this->assertEquals($rand, AInt::random(150, 250, 10)); // Because it's seeded it should give us the same result
    }

    public function testRandomEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$min and \$max parameters must be of type int.");
        AInt::random(false);
    }

    public function testRandomEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$min and \$max parameters must be of type int.");
        AInt::random(5, false);
    }

    public function testRandomErr01()
    {
        $this->assertFalse(@AInt::random(5, -5));

        $this->setExpectedException(
            'PHPUnit_Framework_Error_Warning',
            "The \$min value cannot be greater than the \$max value."
        );
        AInt::random(5, -5);
    }

    // endregion

    // region: Basic numeric operations

    public function testAbs()
    {
        $this->assertEquals(5, AInt::abs(5));
        $this->assertEquals(5, AInt::abs(-5));
    }

    public function testAbsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type int."
        );
        AInt::abs(2.3);
    }

    public function testAdd()
    {
        $this->assertEquals(5, AInt::add(3, 2));
        $this->assertEquals(-5, AInt::add(-3, -2));
        $this->assertEquals(-1, AInt::add(-3, 2));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::add(5, 2.3);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::add(3.4, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, AInt::sub(3, 2));
        $this->assertEquals(-1, AInt::sub(-3, -2));
        $this->assertEquals(-5, AInt::sub(-3, 2));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::sub(5, 2.3);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::sub(3.4, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, AInt::mul(5, 5));
        $this->assertEquals(27, AInt::mul(-9, -3));
        $this->assertEquals(-42, AInt::mul(-7, 6));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::mul(5, 2.3);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::mul(3.4, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, AInt::div(27, 9));
        $this->assertEquals(6, AInt::div(42, 7));
        $this->assertEquals(2, AInt::div(8, 4));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::div(5, 2.3);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        AInt::div(3.4, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$int2 parameter cannot be zero."
        );
        AInt::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, AInt::pow(5, 3));
        $this->assertEquals(-8, AInt::pow(-2, 3));
        $this->assertEquals(15129, AInt::pow(123, 2));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type int."
        );
        AInt::pow(5, 2.3);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type int."
        );
        AInt::pow(3.4, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, AInt::mod(25, 5));
        $this->assertEquals(1, AInt::mod(43, 3));
        $this->assertEquals(6, AInt::mod(278, 8));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type int."
        );
        AInt::mod(5, 2.3);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type int."
        );
        AInt::mod(3.4, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        AInt::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, AInt::sqrt(9));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be of type int.");
        AInt::sqrt(2.3);
    }

    // endregion
}
