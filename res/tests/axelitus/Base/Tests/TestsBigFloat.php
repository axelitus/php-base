<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base\Tests;

use axelitus\Base\BigFloat;

/**
 * Class TestsFloat
 *
 * @package axelitus\Base
 */
class TestsBigFloat extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(BigFloat::is(-5.5));
        $this->assertTrue(BigFloat::is(0.5));
        $this->assertTrue(BigFloat::is(5.5));
        $this->assertTrue(BigFloat::is('-5.5'));
        $this->assertTrue(BigFloat::is('0.5'));
        $this->assertTrue(BigFloat::is('5.5'));
        $this->assertFalse(BigFloat::is(-5));
        $this->assertFalse(BigFloat::is(0));
        $this->assertFalse(BigFloat::is(5));
        $this->assertFalse(BigFloat::is('-5'));
        $this->assertFalse(BigFloat::is('0'));
        $this->assertFalse(BigFloat::is('5'));
        $this->assertFalse(BigFloat::is('string'));
        $this->assertFalse(BigFloat::is(true));
        $this->assertFalse(BigFloat::is(false));
        $this->assertFalse(BigFloat::is([]));
    }

    // endregion

    // region: Conversion

    public function testInt()
    {
        $this->assertEquals(5, BigFloat::int(5.53623544));
        $this->assertEquals('5', BigFloat::int('5.53623544'));
    }

    public function testIntEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float (or string representing a big float)."
        );
        BigFloat::int(false);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, BigFloat::compare(10.5, 20.5));
        $this->assertGreaterThan(0, BigFloat::compare(30.5, 20.5));
        $this->assertEquals(0, BigFloat::compare(15.5, 15.5));

        $this->assertLessThan(0, BigFloat::compare('10.5', 20.5));
        $this->assertGreaterThan(0, BigFloat::compare(30.5, '20.5'));
        $this->assertEquals(0, BigFloat::compare('15.5', '15.5'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::compare(false, 5.5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::compare(-5.5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(BigFloat::equals(10.5, 10.5));
        $this->assertFalse(BigFloat::equals(-10.5, 10.5));
        $this->assertFalse(BigFloat::equals(10.5, -10.5));

        $this->assertTrue(BigFloat::equals('10.5', 10.5));
        $this->assertFalse(BigFloat::equals(-10.5, '10.5'));
        $this->assertFalse(BigFloat::equals('10.5', '-10.5'));
    }

    public function testInRange()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(BigFloat::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigFloat::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigFloat::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(BigFloat::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigFloat::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigFloat::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(BigFloat::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(BigFloat::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(BigFloat::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(BigFloat::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(BigFloat::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(BigFloat::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(BigFloat::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(BigFloat::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 1;
        $range = [0.5, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        BigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1.0;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        BigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1.0;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        BigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigFloat::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(BigFloat::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(BigFloat::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigFloat::inside($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigFloat::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(BigFloat::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(BigFloat::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigFloat::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(BigFloat::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(BigFloat::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(BigFloat::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(BigFloat::between($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(BigFloat::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertFalse(BigFloat::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertFalse(BigFloat::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(BigFloat::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5.75, BigFloat::add(3.5, 2.25));
        $this->assertEquals('5.75', BigFloat::add('3.5', '2.25', 5));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::add(5.0, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::add(false, 5.0);
    }

    public function testSub()
    {
        $this->assertEquals(1.25, BigFloat::sub(3.5, 2.25));
        $this->assertEquals('1.25', BigFloat::sub('3.5', '2.25', 5));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::sub(5.0, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::sub(false, 5.0);
    }

    public function testMul()
    {
        $this->assertEquals(28.875, BigFloat::mul(5.5, 5.25));
        $this->assertEquals('28.875', BigFloat::mul('5.5', '5.25', 5));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::mul(5.0, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::mul(false, 5.0);
    }

    public function testDiv()
    {
        $this->assertEquals(5.5, BigFloat::div(23.375, 4.25));
        $this->assertEquals('5.5', BigFloat::div('23.375', '4.25', 5));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::div(5.0, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        BigFloat::div(false, 5.0);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$float2 parameter cannot be zero."
        );
        BigFloat::div(5.0, 0.0);
    }

    public function testPow()
    {
        $this->assertEquals(97.65625, BigFloat::pow(2.5, 5.0));
        $this->assertEquals('97.65625', BigFloat::pow('2.5', '5.0', 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float (or string representing a big float)."
        );
        BigFloat::pow(5.0, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float (or string representing a big float)."
        );
        BigFloat::pow(false, 5.0);
    }

    public function testMod()
    {
        $this->assertEquals(9.35, BigFloat::mod(328.35, 11.0));
        $this->assertEquals('9.35', BigFloat::mod('328.35', '11.0', 5));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float (or string representing a big float)."
        );
        BigFloat::mod(5.0, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float (or string representing a big float)."
        );
        BigFloat::mod(false, 5.0);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        BigFloat::mod(5.0, 0.0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3.0, BigFloat::sqrt(9.0));
        $this->assertEquals('3.0', BigFloat::sqrt('9.0', 5));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base parameters must be of type float (or string representing a big float)."
        );
        BigFloat::sqrt(false);
    }

    // endregion
}
