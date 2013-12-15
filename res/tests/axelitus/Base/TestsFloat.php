<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.7.2
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Float;

/**
 * Class TestsFloat
 *
 * @package axelitus\Base
 */
class TestsFloat extends TestCase
{
    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(Float::is(-5.5));
        $this->assertTrue(Float::is(0.5));
        $this->assertTrue(Float::is(5.5));
        $this->assertFalse(Float::is(-5));
        $this->assertFalse(Float::is(0));
        $this->assertFalse(Float::is(5));
        $this->assertFalse(Float::is('string'));
        $this->assertFalse(Float::is(true));
        $this->assertFalse(Float::is(false));
        $this->assertFalse(Float::is([]));
    }

    public function testExtIs()
    {
        $this->assertTrue(Float::extIs(-5.5));
        $this->assertTrue(Float::extIs(0.5));
        $this->assertTrue(Float::extIs(5.5));
        $this->assertFalse(Float::extIs(-5));
        $this->assertFalse(Float::extIs(0));
        $this->assertFalse(Float::extIs(5));
        $this->assertTrue(Float::extIs('-5.5'));
        $this->assertTrue(Float::extIs('0.5'));
        $this->assertTrue(Float::extIs('5.5'));
        $this->assertFalse(Float::extIs('5th Street'));
        $this->assertFalse(Float::extIs('-5'));
        $this->assertFalse(Float::extIs('0'));
        $this->assertFalse(Float::extIs('5'));
        $this->assertFalse(Float::extIs('string'));
        $this->assertFalse(Float::extIs(true));
        $this->assertFalse(Float::extIs(false));
        $this->assertFalse(Float::extIs([]));
    }

    //endregion

    //region Conversion

    public function testFrom()
    {
        $this->assertEquals(5.0, Float::From('5.0'));
        $this->assertEquals(9.23, Float::From('9.23'));
        $this->assertEquals(null, Float::From('5')); // this is evaluated as integer so the default value is returned

        $this->assertEquals(null, Float::From('string'));
        $this->assertEquals(5.0, Float::From('string', 5.0));
        $this->assertEquals(9.23, Float::From('string', 9.23));
    }

    //endregion

    //region Comparing

    public function testCompare()
    {
        $this->assertLessThan(0, Float::compare(10.5, 20.5));
        $this->assertGreaterThan(0, Float::compare(30.5, 20.5));
        $this->assertEquals(0, Float::compare(15.5, 15.5));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        Float::compare(false, 5.5);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$float1 and \$float2 parameters must be of type float."
        );
        Float::compare(-5.5, false);
    }

    public function testEquals()
    {
        $this->assertTrue(Float::equals(10.5, 10.5));
        $this->assertFalse(Float::equals(-10.5, 10.5));
        $this->assertFalse(Float::equals(10.5, -10.5));
    }

    public function testInRange()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Float::inRange($value, $rangeA[0], $rangeA[1]));
        $this->assertTrue(Float::inRange($value, $rangeA[0], $rangeA[1], true));
        $this->assertTrue(Float::inRange($value, $rangeA[0], $rangeA[1], false, true));
        $this->assertTrue(Float::inRange($value, $rangeA[0], $rangeA[1], true, true));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(Float::inRange($value, $rangeB[0], $rangeB[1]));
        $this->assertFalse(Float::inRange($value, $rangeB[0], $rangeB[1], true));
        $this->assertTrue(Float::inRange($value, $rangeB[0], $rangeB[1], false, true));
        $this->assertFalse(Float::inRange($value, $rangeB[0], $rangeB[1], true, true));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(Float::inRange($value, $rangeC[0], $rangeC[1]));
        $this->assertTrue(Float::inRange($value, $rangeC[0], $rangeC[1], true));
        $this->assertFalse(Float::inRange($value, $rangeC[0], $rangeC[1], false, true));
        $this->assertFalse(Float::inRange($value, $rangeC[0], $rangeC[1], true, true));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Float::inRange($value, $rangeD[0], $rangeD[1]));
        $this->assertFalse(Float::inRange($value, $rangeD[0], $rangeD[1], true));
        $this->assertFalse(Float::inRange($value, $rangeD[0], $rangeD[1], false, true));
        $this->assertFalse(Float::inRange($value, $rangeD[0], $rangeD[1], true, true));
    }

    public function testInRangeEx01()
    {
        $value = 1;
        $range = [0.5, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        Float::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx02()
    {
        $value = 1.0;
        $range = [0.5, 1];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        Float::inRange($value, $range[0], $range[1]);
    }

    public function testInRangeEx03()
    {
        $value = 1.0;
        $range = [0, 1.5];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$value, \$lower and \$upper parameters must be of type float."
        );
        Float::inRange($value, $range[0], $range[1]);
    }

    public function testInside()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Float::inside($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertTrue(Float::inside($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertTrue(Float::inside($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Float::inside($value, $rangeD[0], $rangeD[1]));
    }

    public function testBetween()
    {
        $value = 3.5;
        $rangeA = [0.5, 5.5];
        $this->assertTrue(Float::between($value, $rangeA[0], $rangeA[1]));

        $rangeB = [3.5, 9.5];
        $this->assertFalse(Float::between($value, $rangeB[0], $rangeB[1]));

        $rangeC = [0.5, 3.5];
        $this->assertFalse(Float::between($value, $rangeC[0], $rangeC[1]));

        $rangeD = [5.5, 9.5];
        $this->assertFalse(Float::between($value, $rangeD[0], $rangeD[1]));
    }

    //endregion

    //region Random

    public function testRandom()
    {
        $rand = Float::random();
        $output = ($rand >= 0.0 && $rand <= 1.0);
        $this->assertTrue(is_float($rand) && $output);

        $rand = Float::random(5.5, 10.5);
        $output = ($rand >= 5.5 && $rand <= 10.5);
        $this->assertTrue(is_float($rand) && $output);

        $rand = Float::random(-20.5, 0.5);
        $output = ($rand >= -20.5 && $rand <= 0.5);
        $this->assertTrue(is_float($rand) && $output);

        $rand = Float::random(-20.5, 0.5, 2);
        $output = ($rand >= -20.5 && $rand <= 0.5);
        $control = (($rand - ((int)$rand)) <= 0.99);
        $this->assertTrue(is_float($rand) && $output && $control);

        $rand = Float::random(150.5, 250.5, null, 10);
        $output = ($rand >= 150.5 && $rand <= 250.5);
        $this->assertTrue(is_float($rand) && $output);
        $this->assertEquals(
            $rand,
            Float::random(150.5, 250.5, null, 10)
        ); // Because it's seeded it should give us the same result
    }

    public function testRandomEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$min and \$max parameters must be of type float."
        );
        Float::random(false);
    }

    public function testRandomEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$min and \$max parameters must be of type float."
        );
        Float::random(5.5, false);
    }

    public function testRandomErr01()
    {
        $this->assertFalse(@Float::random(5.5, -5.5));

        $this->setExpectedException(
            'PHPUnit_Framework_Error_Warning',
            "The \$min value cannot be greater than the \$max value."
        );
        Float::random(5.5, -5.5);
    }

    //endregion

    //region Basic numeric operations

    public function testAdd()
    {
        $this->assertEquals(5.75, Float::add(3.5, 2.25));
    }

    public function testAddEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::add(5.0, false);
    }

    public function testAddEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::add(false, 5.0);
    }

    public function testSub()
    {
        $this->assertEquals(1.25, Float::sub(3.5, 2.25));
    }

    public function testSubEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::sub(5.0, false);
    }

    public function testSubEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::sub(false, 5.0);
    }

    public function testMul()
    {
        $this->assertEquals(28.875, Float::mul(5.5, 5.25));
    }

    public function testMulEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::mul(5.0, false);
    }

    public function testMulEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::mul(false, 5.0);
    }

    public function testDiv()
    {
        $this->assertEquals(5.5, Float::div(23.375, 4.25));
    }

    public function testDivEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::div(5.0, false);
    }

    public function testDivEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$float1 and \$float2 parameters must be of type float.");
        Float::div(false, 5.0);
    }

    public function testDivEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$float2 parameter cannot be zero."
        );
        Float::div(5.0, 0.0);
    }

    public function testPow()
    {
        $this->assertEquals(97.65625, Float::pow(2.5, 5.0));
    }

    public function testPowEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be of type float.");
        Float::pow(5.0, false);
    }

    public function testPowEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$exponent parameters must be of type float.");
        Float::pow(false, 5.0);
    }

    public function testMod()
    {
        $this->assertEquals(9.35, Float::mod(328.35, 11.0));
    }

    public function testModEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be of type float.");
        Float::mod(5.0, false);
    }

    public function testModEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base and \$modulus parameters must be of type float.");
        Float::mod(false, 5.0);
    }

    public function testModEx03()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot divide by zero. The \$modulus parameter cannot be zero."
        );
        Float::mod(5.0, 0.0);
    }

    public function testSqrt()
    {
        $this->assertEquals(3.0, Float::sqrt(9.0));
    }

    public function testSqrtEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$base parameters must be of type float.");
        Float::sqrt(false);
    }

    //endregion
}
