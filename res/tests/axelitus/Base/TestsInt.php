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

use axelitus\Base\Int;

/**
 * Class TestsInt
 *
 * @package axelitus\Base
 */
class TestsInt extends TestCase
{
    //region Constants

    public function testConstants()
    {
        $this->assertEquals(PHP_INT_MAX, Int::MAX);
    }

    //endregion

    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(Int::is(-5));
        $this->assertTrue(Int::is(0));
        $this->assertTrue(Int::is(5));
        $this->assertFalse(Int::is(-5.0));
        $this->assertFalse(Int::is(0.0));
        $this->assertFalse(Int::is(5.0));
        $this->assertFalse(Int::is('string'));
        $this->assertFalse(Int::is(true));
        $this->assertFalse(Int::is(false));
        $this->assertFalse(Int::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(Int::extIs(-5));
        $this->assertTrue(Int::extIs(0));
        $this->assertTrue(Int::extIs(5));
        $this->assertFalse(Int::extIs(-5.0));
        $this->assertFalse(Int::extIs(0.0));
        $this->assertFalse(Int::extIs(5.0));
        $this->assertTrue(Int::extIs('-5'));
        $this->assertTrue(Int::extIs('0'));
        $this->assertTrue(Int::extIs('5'));
        $this->assertFalse(Int::extIs('5th Street'));
        $this->assertFalse(Int::extIs('-5.0'));
        $this->assertFalse(Int::extIs('0.0'));
        $this->assertFalse(Int::extIs('5.0'));
        $this->assertFalse(Int::extIs('string'));
        $this->assertFalse(Int::extIs(true));
        $this->assertFalse(Int::extIs(false));
        $this->assertFalse(Int::extIs([]));
    }

    //endregion

    //region Conversion

    public function testFrom()
    {
        $this->assertEquals(5, Int::From('5'));
        $this->assertEquals(9, Int::From('9'));
        $this->assertEquals(null, Int::From('5.0'));

        $this->assertEquals(null, Int::From('string'));
        $this->assertEquals(5, Int::From('string', 5));
        $this->assertEquals(9, Int::From('string', 9));
    }

    //endregion

    //region Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, Int::compare(10, 20));
        $this->assertGreaterThan(0, Int::compare(30, 20));
        $this->assertEquals(0, Int::compare(15, 15));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        Int::compare(false, 5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$int1 and \$int2 parameters must be of type int."
        );
        Int::compare(-5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(Int::equals(10, 10));
        $this->assertFalse(Int::equals(-10, 10));
        $this->assertFalse(Int::equals(10, -10));
    }

    public function testInRange()
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

    public function testInRangeEx01()
    {
        $value = 0.5;
        $range = [0, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        Int::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        Int::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type int."
        );
        Int::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
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

    public function testBetween()
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

    //endregion

    //region Random

    public function testRandom()
    {
        $rand = Int::random();
        $output = ($rand >= 0 && $rand <= 1);
        $this->assertTrue(is_int($rand) && $output);

        $rand = Int::random(5, 10);
        $output = ($rand >= 5 && $rand <= 10);
        $this->assertTrue(is_int($rand) && $output);

        $rand = Int::random(-20, 0);
        $output = ($rand >= -20 && $rand <= 0);
        $this->assertTrue(is_int($rand) && $output);

        $rand = Int::random(150, 250, 10);
        $output = ($rand >= 150 && $rand <= 250);
        $this->assertTrue(is_int($rand) && $output);
        $this->assertEquals($rand, Int::random(150, 250, 10)); // Because it's seeded it should give us the same result
    }

    public function testRandomEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$min and \$max parameters must be of type int.");
        Int::random(false);
    }

    public function testRandomEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$min and \$max parameters must be of type int.");
        Int::random(5, false);
    }

    public function testRandomErr01()
    {
        $this->assertFalse(@Int::random(5, -5));

        $this->setExpectedException(
            'PHPUnit_Framework_Error_Warning',
            "The \$min value cannot be greater than the \$max value."
        );
        Int::random(5, -5);
    }

    //endregion

    //region Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5, Int::add(3, 2));
        $this->assertEquals(-5, Int::add(-3, -2));
        $this->assertEquals(-1, Int::add(-3, 2));
    }

    public function testAddEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::add(5, 2.3);
    }

    public function testAddEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::add(3.4, 5);
    }

    public function testSub()
    {
        $this->assertEquals(1, Int::sub(3, 2));
        $this->assertEquals(-1, Int::sub(-3, -2));
        $this->assertEquals(-5, Int::sub(-3, 2));
    }

    public function testSubEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::sub(5, 2.3);
    }

    public function testSubEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::sub(3.4, 5);
    }

    public function testMul()
    {
        $this->assertEquals(25, Int::mul(5, 5));
        $this->assertEquals(27, Int::mul(-9, -3));
        $this->assertEquals(-42, Int::mul(-7, 6));
    }

    public function testMulEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::mul(5, 2.3);
    }

    public function testMulEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::mul(3.4, 5);
    }

    public function testDiv()
    {
        $this->assertEquals(3, Int::div(27, 9));
        $this->assertEquals(6, Int::div(42, 7));
        $this->assertEquals(2, Int::div(8, 4));
    }

    public function testDivEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::div(5, 2.3);
    }

    public function testDivEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$int1 and \$int2 parameters must be int.");
        Int::div(3.4, 5);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$int2 parameter cannot be zero."
        );
        Int::div(5, 0);
    }

    public function testPow()
    {
        $this->assertEquals(125, Int::pow(5, 3));
        $this->assertEquals(-8, Int::pow(-2, 3));
        $this->assertEquals(15129, Int::pow(123, 2));
    }

    public function testPowEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be int.");
        Int::pow(5, 2.3);
    }

    public function testPowEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be int.");
        Int::pow(3.4, 5);
    }

    public function testMod()
    {
        $this->assertEquals(0, Int::mod(25, 5));
        $this->assertEquals(1, Int::mod(43, 3));
        $this->assertEquals(6, Int::mod(278, 8));
    }

    public function testModEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be int.");
        Int::mod(5, 2.3);
    }

    public function testModEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be int.");
        Int::mod(3.4, 5);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        Int::mod(5, 0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3, Int::sqrt(9));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be int.");
        Int::sqrt(2.3);
    }

    //endregion
}
