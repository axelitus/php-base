<?php
/**
 * axelitus/base - Primitive extensions and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.4
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Num;
use axelitus\Base\Int;
use axelitus\Base\Float;

/**
 * Class TestsNumeric
 *
 * @package axelitus\Base
 */
class TestsNum extends TestCase
{
    /**
     * Tests the Numeric::is() function.
     */
    public function test_isNumeric()
    {
        $this->assertFalse(Num::is(null), "The value null is incorrectly recognized as numeric.");
        $this->assertTrue(Num::is(0), "The value 0 is not recognized as numeric.");
        $this->assertTrue(Num::is(4), "The value 4 is not recognized as numeric.");
        $this->assertTrue(Num::is(-128), "The value -128 is not recognized as numeric.");
        $this->assertTrue(Num::is(37.84), "The value 37.84 is not recognized as numeric.");
        $this->assertTrue(Num::is(-14.37), "The value -14.37 is not recognized as numeric.");
        $this->assertTrue(Num::is("45"), "The value \"45\" is not recognized as numeric.");
        $this->assertTrue(Num::is("0"), "The value \"0\" is not recognized as numeric.");
        $this->assertTrue(Num::is(new Num(10)), "The value \"[Numeric: { \$value: int(10) }]\" is not recognized as numeric.");
        $this->assertFalse(Num::is("34. This is not numeric"), "The value \"34. This is not numeric\" is incorrectly recognized as numeric.");
        $this->assertFalse(Num::is("This is not numeric 34.56"), "The value \"This is not numeric 34.56\" is incorrectly recognized as numeric.");
        $this->assertFalse(Num::is([]), "The value [] is incorrectly recognized as numeric.");
    }

    /**
     * Tests the Numeric::areEqual() function.
     * @depends test_isNumeric
     */
    public function test_areEqual()
    {
        $this->assertTrue(Num::areEqual(0, 0), "The values 0 and 0 are not evaluated as equal.");
        $this->assertTrue(Num::areEqual(-4, -4), "The values -4 and -4 are not evaluated as equal.");
        $this->assertTrue(Num::areEqual(23, new Num(23)), "The values 23 and [Numeric: { \$value: int(23) }] are not evaluated as equal.");
        $this->assertTrue(Num::areEqual(new Num(5), 5), "The values [Numeric: { \$value: int(5) }] and 5 are not evaluated as equal.");
        $this->assertTrue(Num::areEqual(new Num(9), new Num(9)), "The values [Numeric: { \$value: int(9) }] and [Numeric: { \$value: int(9) }] are not evaluated as equal.");

        // evaluate special cases for numeric with derived classes of PrimitiveNumeric like Int and Float.
        $this->assertTrue(Num::areEqual(5, new Int(5)), "The values 5 and [Int: { \$value: int(5) }] are not evaluated as equal.");
        $this->assertTrue(Num::areEqual(5.8, new Float(5.8)), "The values 5.8 and [Float: { \$value: float(5.8) }] are not evaluated as equal.");

        $this->setExpectedException('\InvalidArgumentException');
        Num::areEqual(0, 'string');
    }

    public function test_doSum()
    {
        $this->assertEquals(9, Num::doSum(1, 2, 2, 4));
        $this->assertEquals(9, Num::doSum([1, 2, 2, 4]));
        $this->assertEquals(9, Num::doSum(1, [2, 2, 4]));
        $this->assertEquals(9, Num::doSum(1, [2, 2], 4));
    }

    public function test_doRest()
    {
        $this->assertEquals(4, Num::doRest(10, 2, 3, 1));
        $this->assertEquals(4, Num::doRest([10, 2, 3, 1]));
        $this->assertEquals(4, Num::doRest(10, [2, 3, 1]));
        $this->assertEquals(4, Num::doRest(10, [2, 3], 1));
    }

    public function test_doMult()
    {
        $this->assertEquals(4, Num::doRest(10, 2, 3, 1));
        $this->assertEquals(4, Num::doRest([10, 2, 3, 1]));
        $this->assertEquals(4, Num::doRest(10, [2, 3, 1]));
        $this->assertEquals(4, Num::doRest(10, [2, 3], 1));
    }

    public function test_doDiv()
    {
        $this->assertEquals(13.351578947368, Num::doDiv(6342, 19, 1, 25));
        $this->assertEquals(13.351578947368, Num::doDiv([6342, 19, 1, 25]));
        $this->assertEquals(13.351578947368, Num::doDiv(6342, [19, 1, 25]));
        $this->assertEquals(13.351578947368, Num::doDiv(6342, [19, 1], 25));
    }

    public function test_doMod()
    {

    }

    public function test_doPow()
    {

    }
}
