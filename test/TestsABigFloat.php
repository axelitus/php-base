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

use axelitus\Base\ABigFloat;

/**
 * Class TestsABigFloat
 *
 * @package axelitus\Base
 */
class TestsABigFloat extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(ABigFloat::is(-5.5));
        $this->assertTrue(ABigFloat::is(0.5));
        $this->assertTrue(ABigFloat::is(5.5));
        $this->assertTrue(ABigFloat::is('-5.5'));
        $this->assertTrue(ABigFloat::is('0.5'));
        $this->assertTrue(ABigFloat::is('5.5'));
        $this->assertFalse(ABigFloat::is(-5));
        $this->assertFalse(ABigFloat::is(0));
        $this->assertFalse(ABigFloat::is(5));
        $this->assertFalse(ABigFloat::is('-5'));
        $this->assertFalse(ABigFloat::is('0'));
        $this->assertFalse(ABigFloat::is('5'));
        $this->assertFalse(ABigFloat::is('string'));
        $this->assertFalse(ABigFloat::is(true));
        $this->assertFalse(ABigFloat::is(false));
        $this->assertFalse(ABigFloat::is([]));
    }

    public function testIsEven()
    {
        $this->assertTrue(ABigFloat::isEven(-8.0));
        $this->assertTrue(ABigFloat::isEven(0.0));
        $this->assertTrue(ABigFloat::isEven(6.0));
        $this->assertFalse(ABigFloat::isEven(-7.0));
        $this->assertFalse(ABigFloat::isEven(5.0));

        $this->assertFalse(ABigFloat::isEven(2.3));
        $this->assertFalse(ABigFloat::isEven(-2.3));

        $this->assertTrue(ABigFloat::isEven('-8.0'));
        $this->assertTrue(ABigFloat::isEven('0.0'));
        $this->assertTrue(ABigFloat::isEven('6.0'));
        $this->assertFalse(ABigFloat::isEven('-7.0'));
        $this->assertFalse(ABigFloat::isEven('5.0'));

        $this->assertTrue(ABigFloat::isEven('2.3'));
        $this->assertFalse(ABigFloat::isEven('2.3', 1));
        $this->assertTrue(ABigFloat::isEven('-2.3'));
        $this->assertFalse(ABigFloat::isEven('-2.3', 1));
    }

    public function testIsEvenEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float (or string representing a big float)."
        );
        ABigFloat::isEven(false);
    }

    public function testIsOdd()
    {
        $this->assertTrue(ABigFloat::isOdd(-7.0));
        $this->assertTrue(ABigFloat::isOdd(5.0));
        $this->assertFalse(ABigFloat::isOdd(-8.0));
        $this->assertFalse(ABigFloat::isOdd(0.0));
        $this->assertFalse(ABigFloat::isOdd(6.0));

        $this->assertFalse(ABigFloat::isOdd(3.2));
        $this->assertFalse(ABigFloat::isOdd(-3.2));

        $this->assertTrue(ABigFloat::isOdd('-7.0'));
        $this->assertTrue(ABigFloat::isOdd('5.0'));
        $this->assertFalse(ABigFloat::isOdd('-8.0'));
        $this->assertFalse(ABigFloat::isOdd('0.0'));
        $this->assertFalse(ABigFloat::isOdd('6.0'));

        $this->assertTrue(ABigFloat::isOdd('3.2'));
        $this->assertFalse(ABigFloat::isOdd('3.2', 1));
        $this->assertTrue(ABigFloat::isOdd('-3.2'));
        $this->assertFalse(ABigFloat::isOdd('-3.2', 1));
    }

    public function testIsOddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float (or string representing a big float)."
        );
        ABigFloat::isOdd(false);
    }

    // endregion

    // region: Conversion

    public function testToInt()
    {
        $this->assertEquals(5, ABigFloat::toInt(5.53623544));
        $this->assertEquals('5', ABigFloat::toInt('5.53623544'));
    }

    public function testToIntEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float (or string representing a big float)."
        );
        ABigFloat::toInt(false);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, ABigFloat::compare(10.5, 20.5));
        $this->assertGreaterThan(0, ABigFloat::compare(30.5, 20.5));
        $this->assertEquals(0, ABigFloat::compare(15.5, 15.5));

        $this->assertLessThan(0, ABigFloat::compare('10.5', 20.5));
        $this->assertGreaterThan(0, ABigFloat::compare(30.5, '20.5'));
        $this->assertEquals(0, ABigFloat::compare('15.5', '15.5'));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::compare(false, 5.5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::compare(-5.5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(ABigFloat::equals(10.5, 10.5));
        $this->assertFalse(ABigFloat::equals(-10.5, 10.5));
        $this->assertFalse(ABigFloat::equals(10.5, -10.5));

        $this->assertTrue(ABigFloat::equals('10.5', 10.5));
        $this->assertFalse(ABigFloat::equals(-10.5, '10.5'));
        $this->assertFalse(ABigFloat::equals('10.5', '-10.5'));
    }

    public function testInRange()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ABigFloat::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ABigFloat::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], true, true));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(ABigFloat::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(ABigFloat::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(ABigFloat::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 1;
        $range = [0.5, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1.0;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1.0;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigFloat::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(ABigFloat::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(ABigFloat::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigFloat::inside($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigFloat::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertTrue(ABigFloat::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertTrue(ABigFloat::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigFloat::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(ABigFloat::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(ABigFloat::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(ABigFloat::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(ABigFloat::between($value, $rangeD[0], $rangeD[1]));

        $value = '3.5';
        $rangeA = ['0.5', '5.5'];
        $this->assertTrue(ABigFloat::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = ['3.5', '9.5'];
        $this->assertFalse(ABigFloat::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = ['0.5', '3.5'];
        $this->assertFalse(ABigFloat::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = ['5.5', '9.5'];
        $this->assertFalse(ABigFloat::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Basic numeric operations

    public function testAbs()
    {
        $this->assertEquals(5.5, ABigFloat::abs(5.5));
        $this->assertEquals(5.5, ABigFloat::abs(-5.5));
        $this->assertEquals('5.5', ABigFloat::abs('5.5'));
        $this->assertEquals('5.5', ABigFloat::abs('-5.5'));
    }

    public function testAbsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float parameter must be of type float (or string representing a big float)."
        );
        ABigFloat::abs(false);
    }

    public function testAdd()
    {
        $this->assertEquals(5.75, ABigFloat::add(3.5, 2.25));
        $this->assertEquals('5.75', ABigFloat::add('3.5', '2.25', 5));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::add(5.0, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::add(false, 5.0);
    }

    public function testSub()
    {
        $this->assertEquals(1.25, ABigFloat::sub(3.5, 2.25));
        $this->assertEquals('1.25', ABigFloat::sub('3.5', '2.25', 5));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::sub(5.0, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::sub(false, 5.0);
    }

    public function testMul()
    {
        $this->assertEquals(28.875, ABigFloat::mul(5.5, 5.25));
        $this->assertEquals('28.875', ABigFloat::mul('5.5', '5.25', 5));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::mul(5.0, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::mul(false, 5.0);
    }

    public function testDiv()
    {
        $this->assertEquals(5.5, ABigFloat::div(23.375, 4.25));
        $this->assertEquals('5.5', ABigFloat::div('23.375', '4.25', 5));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::div(5.0, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::div(false, 5.0);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$float2 parameter cannot be zero."
        );
        ABigFloat::div(5.0, 0.0);
    }

    public function testPow()
    {
        $this->assertEquals(97.65625, ABigFloat::pow(2.5, 5.0));
        $this->assertEquals('97.65625', ABigFloat::pow('2.5', '5.0', 5));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::pow(5.0, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::pow(false, 5.0);
    }

    public function testMod()
    {
        $this->assertEquals(9.35, ABigFloat::mod(328.35, 11.0));
        $this->assertEquals('9.35', ABigFloat::mod('328.35', '11.0', 5));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::mod(5.0, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::mod(false, 5.0);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        ABigFloat::mod(5.0, 0.0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3.0, ABigFloat::sqrt(9.0));
        $this->assertEquals('3.0', ABigFloat::sqrt('9.0', 5));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base parameters must be of type float (or string representing a big float)."
        );
        ABigFloat::sqrt(false);
    }

    // endregion
}
