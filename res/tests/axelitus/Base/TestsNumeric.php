<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.4
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Numeric;
use axelitus\Base\Int;
use axelitus\Base\Float;

/**
 * Class TestsNumeric
 *
 * @package axelitus\Base
 */
class TestsNumeric extends TestCase
{
    /**
     * Tests the Numeric::is() function.
     */
    public function test_isNumeric()
    {
        $this->assertFalse(Numeric::is(null), "The value null is incorrectly recognized as numeric.");
        $this->assertTrue(Numeric::is(0), "The value 0 is not recognized as numeric.");
        $this->assertTrue(Numeric::is(4), "The value 4 is not recognized as numeric.");
        $this->assertTrue(Numeric::is(-128), "The value -128 is not recognized as numeric.");
        $this->assertTrue(Numeric::is(37.84), "The value 37.84 is not recognized as numeric.");
        $this->assertTrue(Numeric::is(-14.37), "The value -14.37 is not recognized as numeric.");
        $this->assertTrue(Numeric::is("45"), "The value \"45\" is not recognized as numeric.");
        $this->assertTrue(Numeric::is("0"), "The value \"0\" is not recognized as numeric.");
        $this->assertTrue(Numeric::is(new Numeric(10)), "The value \"[Numeric: { \$value: int(10) }]\" is not recognized as numeric.");
        $this->assertFalse(Numeric::is("34. This is not numeric"), "The value \"34. This is not numeric\" is incorrectly recognized as numeric.");
        $this->assertFalse(Numeric::is("This is not numeric 34.56"), "The value \"This is not numeric 34.56\" is incorrectly recognized as numeric.");
        $this->assertFalse(Numeric::is([]), "The value [] is incorrectly recognized as numeric.");
    }

    /**
     * Tests the Numeric::areEqual() function.
     * @depends test_isNumeric
     */
    public function test_areEqual()
    {
        $this->assertTrue(Numeric::areEqual(0, 0), "The values 0 and 0 are not evaluated as equal.");
        $this->assertTrue(Numeric::areEqual(-4, -4), "The values -4 and -4 are not evaluated as equal.");
        $this->assertTrue(Numeric::areEqual(23, new Numeric(23)), "The values 23 and [Numeric: { \$value: int(23) }] are not evaluated as equal.");
        $this->assertTrue(Numeric::areEqual(new Numeric(5), 5), "The values [Numeric: { \$value: int(5) }] and 5 are not evaluated as equal.");
        $this->assertTrue(Numeric::areEqual(new Numeric(9), new Numeric(9)), "The values [Numeric: { \$value: int(9) }] and [Numeric: { \$value: int(9) }] are not evaluated as equal.");

        // evaluate special cases for numeric with derived classes of PrimitiveNumeric like Int and Float.
        $this->assertTrue(Numeric::areEqual(5, new Int(5)), "The values 5 and [Int: { \$value: int(5) }] are not evaluated as equal.");
        $this->assertTrue(Numeric::areEqual(5.8, new Float(5.8)), "The values 5.8 and [Float: { \$value: float(5.8) }] are not evaluated as equal.");

        $this->setExpectedException('\InvalidArgumentException');
        Numeric::areEqual(0, 'string');
    }

    public function test_doSum()
    {
        $this->assertEquals(9, Numeric::doSum(1, 2, 2, 4));
        $this->assertEquals(9, Numeric::doSum([1, 2, 2, 4]));
        $this->assertEquals(9, Numeric::doSum(1, [2, 2, 4]));
        $this->assertEquals(9, Numeric::doSum(1, [2, 2], 4));
    }

    public function test_doRest()
    {
        $this->assertEquals(4, Numeric::doRest(10, 2, 3, 1));
        $this->assertEquals(4, Numeric::doRest([10, 2, 3, 1]));
        $this->assertEquals(4, Numeric::doRest(10, [2, 3, 1]));
        $this->assertEquals(4, Numeric::doRest(10, [2, 3], 1));
    }

    public function test_doMult()
    {
        $this->assertEquals(4, Numeric::doRest(10, 2, 3, 1));
        $this->assertEquals(4, Numeric::doRest([10, 2, 3, 1]));
        $this->assertEquals(4, Numeric::doRest(10, [2, 3, 1]));
        $this->assertEquals(4, Numeric::doRest(10, [2, 3], 1));
    }

    public function test_doDiv()
    {
        $this->assertEquals(13.351578947368, Numeric::doDiv(6342, 19, 1, 25));
        $this->assertEquals(13.351578947368, Numeric::doDiv([6342, 19, 1, 25]));
        $this->assertEquals(13.351578947368, Numeric::doDiv(6342, [19, 1, 25]));
        $this->assertEquals(13.351578947368, Numeric::doDiv(6342, [19, 1], 25));
    }

    public function test_doMod()
    {

    }

    public function test_doPow()
    {

    }
}
