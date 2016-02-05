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

use axelitus\Base\AFloat;

/**
 * Class TestsAFloat
 *
 * @package axelitus\Base
 */
class TestsAFloat extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(AFloat::is(-5.5));
        $this->assertTrue(AFloat::is(0.5));
        $this->assertTrue(AFloat::is(5.5));
        $this->assertFalse(AFloat::is(-5));
        $this->assertFalse(AFloat::is(0));
        $this->assertFalse(AFloat::is(5));
        $this->assertFalse(AFloat::is('string'));
        $this->assertFalse(AFloat::is(true));
        $this->assertFalse(AFloat::is(false));
        $this->assertFalse(AFloat::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(AFloat::extIs(-5.5));
        $this->assertTrue(AFloat::extIs(0.5));
        $this->assertTrue(AFloat::extIs(5.5));
        $this->assertFalse(AFloat::extIs(-5));
        $this->assertFalse(AFloat::extIs(0));
        $this->assertFalse(AFloat::extIs(5));
        $this->assertTrue(AFloat::extIs('-5.5'));
        $this->assertTrue(AFloat::extIs('0.5'));
        $this->assertTrue(AFloat::extIs('5.5'));
        $this->assertFalse(AFloat::extIs('5th Street'));
        $this->assertFalse(AFloat::extIs('-5'));
        $this->assertFalse(AFloat::extIs('0'));
        $this->assertFalse(AFloat::extIs('5'));
        $this->assertFalse(AFloat::extIs('string'));
        $this->assertFalse(AFloat::extIs(true));
        $this->assertFalse(AFloat::extIs(false));
        $this->assertFalse(AFloat::extIs([]));
    }

    public function testIsEven()
    {
        $this->assertTrue(AFloat::isEven(-8.0));
        $this->assertTrue(AFloat::isEven(0.0));
        $this->assertTrue(AFloat::isEven(6.0));
        $this->assertFalse(AFloat::isEven(-7.0));
        $this->assertFalse(AFloat::isEven(5.0));

        $this->assertFalse(AFloat::isEven(2.3));
        $this->assertFalse(AFloat::isEven(-2.3));
    }

    public function testIsEvenEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float."
        );
        AFloat::isEven(false);
    }

    public function testIsOdd()
    {
        $this->assertTrue(AFloat::isOdd(-7.0));
        $this->assertTrue(AFloat::isOdd(5.0));
        $this->assertFalse(AFloat::isOdd(-8.0));
        $this->assertFalse(AFloat::isOdd(0.0));
        $this->assertFalse(AFloat::isOdd(6.0));

        $this->assertFalse(AFloat::isEven(3.2));
        $this->assertFalse(AFloat::isEven(-3.2));
    }

    public function testIsOddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value parameter must be of type float."
        );
        AFloat::isOdd(false);
    }

    // endregion

    // region: Conversion

    public function testParse()
    {
        $this->assertEquals(5.0, AFloat::parse('5.0'));
        $this->assertEquals(9.23, AFloat::parse('9.23'));
        $this->assertEquals(5.0, AFloat::parse('5'));

        $this->assertEquals(null, AFloat::parse('string'));
        $this->assertEquals(5.0, AFloat::parse('string', 5.0));
        $this->assertEquals(9.23, AFloat::parse('string', 9.23));
    }

    public function testToInt()
    {
        $int = AFloat::toInt(5.0);
        $this->assertEquals(5, $int);
        $this->assertTrue(is_int($int));
    }

    public function testToIntEx01()
    {
        $this->setExpectedException('\InvalidArgumentException',
            "The \$value parameter must be of type float."
        );
        AFloat::toInt(5);
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, AFloat::compare(10.5, 20.5));
        $this->assertGreaterThan(0, AFloat::compare(30.5, 20.5));
        $this->assertEquals(0, AFloat::compare(15.5, 15.5));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::compare(false, 5.5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::compare(-5.5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(AFloat::equals(10.5, 10.5));
        $this->assertFalse(AFloat::equals(-10.5, 10.5));
        $this->assertFalse(AFloat::equals(10.5, -10.5));
    }

    public function testInRange()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(AFloat::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(AFloat::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(AFloat::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(AFloat::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(AFloat::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(AFloat::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(AFloat::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(AFloat::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(AFloat::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(AFloat::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(AFloat::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(AFloat::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(AFloat::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(AFloat::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(AFloat::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(AFloat::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 1;
        $range = [0.5, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        AFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1.0;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        AFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1.0;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        AFloat::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(AFloat::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(AFloat::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(AFloat::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(AFloat::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(AFloat::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(AFloat::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(AFloat::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(AFloat::between($value, $rangeD[0], $rangeD[1]));
    }

    // endregion

    // region: Random

    public function testRandom()
    {
        $rand = AFloat::random();
        $output = ($rand >= 0.0 && $rand <= 1.0);
        $this->assertTrue(is_float($rand) && $output);

        $rand = AFloat::random(5.5, 10.5);
        $output = ($rand >= 5.5 && $rand <= 10.5);
        $this->assertTrue(is_float($rand) && $output);

        $rand = AFloat::random(-20.5, 0.5);
        $output = ($rand >= -20.5 && $rand <= 0.5);
        $this->assertTrue(is_float($rand) && $output);

        $rand = AFloat::random(-20.5, 0.5, 2);
        $output = ($rand >= -20.5 && $rand <= 0.5);
        $control = (($rand - ((int)$rand)) <= 0.99);
        $this->assertTrue(is_float($rand) && $output && $control);

        $rand = AFloat::random(150.5, 250.5, null, 10);
        $output = ($rand >= 150.5 && $rand <= 250.5);
        $this->assertTrue(is_float($rand) && $output);
        $this->assertEquals(
            $rand,
            AFloat::random(150.5, 250.5, null, 10)
        ); // Because it's seeded it should give us the same result
    }

    public function testRandomEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$min and \$max parameters must be of type float."
        );
        AFloat::random(false);
    }

    public function testRandomEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$min and \$max parameters must be of type float."
        );
        AFloat::random(5.5, false);
    }

    public function testRandomErr01()
    {
        $this->assertFalse(@AFloat::random(5.5, -5.5));

        $this->setExpectedException(
            'PHPUnit_Framework_Error_Warning',
            "The \$min value cannot be greater than the \$max value."
        );
        AFloat::random(5.5, -5.5);
    }

    // endregion

    // region: Basic numeric operations

    public function testAbs()
    {
        $this->assertEquals(5.5, AFloat::abs(5.5));
        $this->assertEquals(5.5, AFloat::abs(-5.5));
    }

    public function testAbsEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float parameter must be of type float."
        );
        AFloat::abs(false);
    }

    public function testAdd()
    {
        $this->assertEquals(5.75, AFloat::add(3.5, 2.25));
    }

    public function testAddEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::add(5.0, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::add(false, 5.0);
    }

    public function testSub()
    {
        $this->assertEquals(1.25, AFloat::sub(3.5, 2.25));
    }

    public function testSubEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::sub(5.0, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::sub(false, 5.0);
    }

    public function testMul()
    {
        $this->assertEquals(28.875, AFloat::mul(5.5, 5.25));
    }

    public function testMulEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::mul(5.0, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::mul(false, 5.0);
    }

    public function testDiv()
    {
        $this->assertEquals(5.5, AFloat::div(23.375, 4.25));
    }

    public function testDivEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::div(5.0, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        AFloat::div(false, 5.0);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$float2 parameter cannot be zero."
        );
        AFloat::div(5.0, 0.0);
    }

    public function testPow()
    {
        $this->assertEquals(97.65625, AFloat::pow(2.5, 5.0));
    }

    public function testPowEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float."
        );
        AFloat::pow(5.0, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$exponent parameters must be of type float."
        );
        AFloat::pow(false, 5.0);
    }

    public function testMod()
    {
        $this->assertEquals(9.35, AFloat::mod(328.35, 11.0));
    }

    public function testModEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float."
        );
        AFloat::mod(5.0, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$base and \$modulus parameters must be of type float."
        );
        AFloat::mod(false, 5.0);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        AFloat::mod(5.0, 0.0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3.0, AFloat::sqrt(9.0));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be of type float.");
        AFloat::sqrt(false);
    }

    // endregion
}
