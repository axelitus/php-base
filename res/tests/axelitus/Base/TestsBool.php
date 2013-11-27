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

use axelitus\Base\Bool;

/**
 * Class TestsBoolean
 *
 * @package axelitus\Base
 */
class TestsBool extends TestCase
{
    //region Value Testing

    public function testIs()
    {
        $this->assertTrue(Bool::is(true));
        $this->assertTrue(Bool::is(false));
        $this->assertTrue(Bool::is(1));
        $this->assertTrue(Bool::is(0));
        $this->assertFalse(Bool::is('true'));
        $this->assertFalse(Bool::is(10));
        $this->assertFalse(Bool::is(-10));
    }

    public function testOpNot()
    {
        $this->assertTrue(Bool::opNot(false));
        $this->assertFalse(Bool::opNot(true));
        $this->assertEquals([true, false], Bool::opNot(false, true));
        $this->assertEquals([false, true, true], Bool::opNot(true, false, false));
        $this->assertEquals([true, false, false, true, false], Bool::opNot(false, true, true, false, true));
        $this->assertEquals([true], Bool::opNot([false]));
        $this->assertEquals([false], Bool::opNot([true]));
        $this->assertEquals([true, false], Bool::opNot([false, true]));
        $this->assertEquals([false, true, true], Bool::opNot([true, false, false]));
        $this->assertEquals([true, false, false, true, false], Bool::opNot([false, true, true, false, true]));
        $this->assertEquals([true, [false, false, true], false], Bool::opNot(false, [true, true, false], true));
    }

    //endregion

    //region Parsing

    public function testParse()
    {
        $this->assertTrue(Bool::parse('true'));
        $this->assertFalse(Bool::parse('false'));
        $this->assertTrue(Bool::parse('1'));
        $this->assertFalse(Bool::parse('0'));
    }

    public function testParseEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$input parameter must be a non-empty string.");
        $val = Bool::parse(9);
    }

    public function testParseEx02()
    {
        $this->setExpectedException('\RuntimeException', "The \$input string cannot be parsed because it does not match 'true', 'false', '1' or '0'.");
        $val = Bool::parse('yes');
    }

    public function testExtParse()
    {
        $this->assertTrue(Bool::extParse('true'));
        $this->assertTrue(Bool::extParse('TRUE'));
        $this->assertTrue(Bool::extParse('on'));
        $this->assertTrue(Bool::extParse('ON'));
        $this->assertTrue(Bool::extParse('yes'));
        $this->assertTrue(Bool::extParse('Yes'));
        $this->assertTrue(Bool::extParse('y'));
        $this->assertTrue(Bool::extParse('Y'));
        $this->assertTrue(Bool::extParse('1'));
        $this->assertFalse(Bool::extParse('false'));
        $this->assertFalse(Bool::extParse('FALSE'));
        $this->assertFalse(Bool::extParse('off'));
        $this->assertFalse(Bool::extParse('OFF'));
        $this->assertFalse(Bool::extParse('no'));
        $this->assertFalse(Bool::extParse('No'));
        $this->assertFalse(Bool::extParse('n'));
        $this->assertFalse(Bool::extParse('N'));
        $this->assertFalse(Bool::extParse('0'));
    }

    public function testExtParseEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$input parameter must be a non-empty string.");
        $val = Bool::extParse(9);
    }

    public function testExtParseEx02()
    {
        $this->setExpectedException('\RuntimeException', "The \$input parameter did not match any of the valid strings that can be parsed.");
        $val = Bool::extParse('valid');
    }

    //endregion

    //region NOT operation

    public function testOpNot()
    {
        $this->assertTrue(Bool::opNot(false));
        $this->assertFalse(Bool::opNot(true));
        $this->assertEquals([true, false], Bool::opNot(false, true));
        $this->assertEquals([false, true, true], Bool::opNot(true, false, false));
        $this->assertEquals([true, false, false, true, false], Bool::opNot(false, true, true, false, true));
        $this->assertEquals([true], Bool::opNot([false]));
        $this->assertEquals([false], Bool::opNot([true]));
        $this->assertEquals([true, false], Bool::opNot([false, true]));
        $this->assertEquals([false, true, true], Bool::opNot([true, false, false]));
        $this->assertEquals([true, false, false, true, false], Bool::opNot([false, true, true, false, true]));
        $this->assertEquals([true, [false, false, true], false], Bool::opNot(false, [true, true, false], true));
    }

    public function testOpNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opNot([true, true, 'string']);
    }

    public function testOpNotEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All values must be of type bool.");
        Bool::opNot(true, true, 'string');
    }

    //endregion

    //region AND operation

    public function testOpAnd()
    {
        $this->assertTrue(Bool::opAnd(true, true));
        $this->assertFalse(Bool::opAnd(true, false));
        $this->assertTrue(Bool::opAnd(true, true, true, true, true));
        $this->assertFalse(Bool::opAnd(true, true, true, false, true));

        $this->assertTrue(Bool::opAnd([true, true]));
        $this->assertFalse(Bool::opAnd([true, false]));
        $this->assertTrue(Bool::opAnd([true, true, true, true, true]));
        $this->assertFalse(Bool::opAnd([true, true, true, false, true]));

        $this->assertEquals(
            [true, false, false, true],
            Bool::opAnd([true, true, true], [true, false, true], [false, false, true], [true, true, true])
        );
    }

    public function testOpAndEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "Cannot mix value types. All values must be of the same type (in this case array).");
        Bool::opAnd([true, true], true);
    }

    public function testOpAndEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opAnd([true, true, true], [true, true, 'string']);
    }

    public function testOpAndEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opAnd([5, 'string']);
    }

    public function testOpAndEx04()
    {
        $this->setExpectedException('\InvalidArgumentException', "Cannot mix value types. All values must be of the same type (in this case bool).");
        Bool::opAnd(true, [true, true]);
    }

    public function testOpAndEx05()
    {
        $this->setExpectedException('\InvalidArgumentException', "All values must be of type bool or array.");
        $val = Bool::opAnd(5, 'string');
    }

    //endregion

    //region OR operation

    public function testOpOr()
    {
        $this->assertTrue(Bool::opOr(true, true));
        $this->assertTrue(Bool::opOr(true, false));
        $this->assertTrue(Bool::opOr(false, false, true, false, false));
        $this->assertFalse(Bool::opOr(false, false));
        $this->assertFalse(Bool::opOr(false, false, false, false, false));

        $this->assertTrue(Bool::opOr([true, true]));
        $this->assertTrue(Bool::opOr([true, false]));
        $this->assertTrue(Bool::opOr([false, false, true, false, false]));
        $this->assertFalse(Bool::opOr([false, false]));
        $this->assertFalse(Bool::opOr([false, false, false, false, false]));

        $this->assertEquals(
            [true, false, false, true],
            Bool::opOr([true, false, false], [false, false, false], [false, false, false], [false, true, true])
        );
    }

    public function testOpOrEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "Cannot mix value types. All values must be of the same type (in this case array).");
        Bool::opOr([true, true], true);
    }

    public function testOpOrEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opOr([true, true, true], [true, true, 'string']);
    }

    public function testOpOrEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opOr([5, 'string']);
    }

    public function testOpOrEx04()
    {
        $this->setExpectedException('\InvalidArgumentException', "Cannot mix value types. All values must be of the same type (in this case bool).");
        Bool::opOr(true, [true, true]);
    }

    public function testOpOrEx05()
    {
        $this->setExpectedException('\InvalidArgumentException', "All values must be of type bool or array.");
        $val = Bool::opOr(5, 'string');
    }

    //endregion

//
//    /**
//     * Tests Boolean::eqWith()
//     *
//     * @depends test_doEq
//     */
//    public function test_eqWith()
//    {
//        $this->assertFalse($this->booleanTrue->eqWith(false));
//        $this->assertFalse($this->booleanFalse->eqWith(true));
//        $this->assertTrue($this->booleanTrue->eqWith(true));
//        $this->assertTrue($this->booleanFalse->eqWith(false));
//
//        $this->assertEquals([true, false, false], $this->booleanTrue->eqWith([true, false, false]));
//        $this->assertEquals([false, true, true], $this->booleanFalse->eqWith([true, false, false]));
//    }
//
//    /**
//     * Tests PrimitiveBoolean::doXor()
//     *
//     * @depends test_doEq
//     */
//    public function test_doXor()
//    {
//        $this->assertTrue(Bool::doXor(true, false));
//        $this->assertTrue(Bool::doXor(false, true));
//        $this->assertFalse(Bool::doXor(true, true));
//        $this->assertFalse(Bool::doXor(false, false));
//
//        $this->assertEquals([false, true, false], Bool::doXor([true, true, false], [true, false, false]));
//    }
//
//    /**
//     * Tests Boolean::xorWith()
//     *
//     * @depends test_doXor
//     */
//    public function test_xorWith()
//    {
//        $this->assertTrue($this->booleanTrue->xorWith(false));
//        $this->assertTrue($this->booleanFalse->xorWith(true));
//        $this->assertFalse($this->booleanTrue->xorWith(true));
//        $this->assertFalse($this->booleanFalse->xorWith(false));
//
//        $this->assertEquals([false, true, true], $this->booleanTrue->xorWith([true, false, false]));
//        $this->assertEquals([true, false, false], $this->booleanFalse->xorWith([true, false, false]));
//    }
}
