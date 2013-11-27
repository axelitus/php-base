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

//    /** @var axelitus\Base\Boolean $booleanTrue */
//    protected $booleanTrue;
//
//    /** @var axelitus\Base\Boolean $booleanFalse */
//    protected $booleanFalse;
//
//    public function setUp() {
//        $this->booleanTrue = new Bool(true);
//        $this->booleanFalse = new Bool(false);
//    }
//
//    /**
//     * Tests PrimitiveBoolean::is()
//     */
//    public function test_isBool()
//    {
//        $this->assertTrue(Bool::is(true), "The value true is not recognized as a boolean.");
//        $this->assertTrue(Bool::is(false), "The value false is not recognized as a boolean.");
//        $this->assertTrue(Bool::is(1), "The value 1 is not recognized as a boolean.");
//        $this->assertTrue(Bool::is(0), "The value 0 is not recognized as a boolean.");
//        $this->assertFalse(Bool::is("true"), "The value \"true\" is incorrectly recognized as a boolean.");
//        $this->assertFalse(Bool::is("false"), "The value \"false\" is incorrectly recognized as a boolean.");
//        $this->assertFalse(Bool::is("1"), "The value \"1\" is incorrectly recognized as a boolean.");
//        $this->assertFalse(Bool::is("0"), "The value \"0\" is incorrectly recognized as a boolean.");
//    }
//
//    /**
//     * Tests PrimitiveBoolean::doNot()
//     */
//    public function test_doNot()
//    {
//        $this->assertTrue(Bool::doNot(false));
//        $this->assertFalse(Bool::doNot(true));
//    }
//
//    /**
//     * Tests PrimitiveBoolean::doAnd()
//     */
//    public function test_doAnd()
//    {
//        $this->assertTrue(Bool::doAnd(true, true, true, true));
//        $this->assertFalse(Bool::doAnd(true, false, true, true));
//        $this->assertTrue(Bool::doAnd([true, true, true, true], true));
//        $this->assertFalse(Bool::doAnd([true, true, true, true], false));
//        $this->assertFalse(Bool::doAnd([true, true, false, true], true));
//    }
//
//    /**
//     * Tests Boolean::andWith()
//     *
//     * @depends test_doAnd
//     */
//    public function test_andWith()
//    {
//        $this->assertFalse($this->booleanTrue->andWith($this->booleanFalse));
//        $this->assertFalse($this->booleanFalse->andWith($this->booleanTrue));
//        $this->assertTrue($this->booleanTrue->andWith(true));
//        $this->assertTrue($this->booleanTrue->andWith([true, true, true]));
//        $this->assertFalse($this->booleanTrue->andWith([true, true, false]));
//    }
//
//    /**
//     * Tests PrimitiveBoolean::doOr()
//     */
//    public function test_doOr()
//    {
//        $this->assertTrue(Bool::doOr(true, true, true, true));
//        $this->assertTrue(Bool::doOr(false, false, true, false));
//        $this->assertFalse(Bool::doOr(false, false, false, false));
//        $this->assertTrue(Bool::doOr([false, false, false, false], true));
//        $this->assertFalse(Bool::doOr([false, false, false, false], false));
//        $this->assertTrue(Bool::doOr([false, false, true, false], false));
//    }
//
//    /**
//     * Tests Boolean::orWith()
//     *
//     * @depends test_doOr
//     */
//    public function test_orWith()
//    {
//        $this->assertTrue($this->booleanTrue->orWith(true, true, true));
//        $this->assertTrue($this->booleanFalse->orWith(false, true, false));
//        $this->assertFalse($this->booleanFalse->orWith(false, false, false));
//        $this->assertTrue($this->booleanFalse->orWith([false, false, false, false], true));
//        $this->assertFalse($this->booleanFalse->orWith([false, false, false, false], false));
//        $this->assertTrue($this->booleanFalse->orWith([false, false, true, false], false));
//    }
//
//    /**
//     * Tests PrimitiveBoolean::doEq()
//     */
//    public function test_doEq()
//    {
//        $this->assertFalse(Bool::doEq(true, false));
//        $this->assertFalse(Bool::doEq(false, true));
//        $this->assertTrue(Bool::doEq(true, true));
//        $this->assertTrue(Bool::doEq(false, false));
//
//        $this->assertEquals([true, false, true], Bool::doEq([true, true, false], [true, false, false]));
//    }
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
