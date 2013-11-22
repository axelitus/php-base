<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.3
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Boolean;

/**
 * Class TestsBoolean
 *
 * @package axelitus\Base
 */
class TestsBoolean extends TestCase
{
    /** @var axelitus\Base\Boolean $booleanTrue */
    protected $booleanTrue;

    /** @var axelitus\Base\Boolean $booleanFalse */
    protected $booleanFalse;

    public function setUp() {
        $this->booleanTrue = new Boolean(true);
        $this->booleanFalse = new Boolean(false);
    }

    /**
     * Tests PrimitiveBoolean::is()
     */
    public function test_isBool()
    {
        $this->assertTrue(Boolean::is(true), "The value true is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(false), "The value false is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(1), "The value 1 is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(0), "The value 0 is not recognized as a boolean.");
        $this->assertFalse(Boolean::is("true"), "The value \"true\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("false"), "The value \"false\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("1"), "The value \"1\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("0"), "The value \"0\" is incorrectly recognized as a boolean.");
    }

    /**
     * Tests PrimitiveBoolean::doNot()
     */
    public function test_doNot()
    {
        $this->assertTrue(Boolean::doNot(false));
        $this->assertFalse(Boolean::doNot(true));
    }

    /**
     * Tests PrimitiveBoolean::doAnd()
     */
    public function test_doAnd()
    {
        $this->assertTrue(Boolean::doAnd(true, true, true, true));
        $this->assertFalse(Boolean::doAnd(true, false, true, true));
        $this->assertTrue(Boolean::doAnd([true, true, true, true], true));
        $this->assertFalse(Boolean::doAnd([true, true, true, true], false));
        $this->assertFalse(Boolean::doAnd([true, true, false, true], true));
    }

    /**
     * Tests Boolean::andWith()
     *
     * @depends test_doAnd
     */
    public function test_andWith()
    {
        $this->assertFalse($this->booleanTrue->andWith($this->booleanFalse));
        $this->assertFalse($this->booleanFalse->andWith($this->booleanTrue));
        $this->assertTrue($this->booleanTrue->andWith(true));
        $this->assertTrue($this->booleanTrue->andWith([true, true, true]));
        $this->assertFalse($this->booleanTrue->andWith([true, true, false]));
    }

    /**
     * Tests PrimitiveBoolean::doOr()
     */
    public function test_doOr()
    {
        $this->assertTrue(Boolean::doOr(true, true, true, true));
        $this->assertTrue(Boolean::doOr(false, false, true, false));
        $this->assertFalse(Boolean::doOr(false, false, false, false));
        $this->assertTrue(Boolean::doOr([false, false, false, false], true));
        $this->assertFalse(Boolean::doOr([false, false, false, false], false));
        $this->assertTrue(Boolean::doOr([false, false, true, false], false));
    }

    /**
     * Tests PrimitiveBoolean::doEq()
     */
    public function test_doEq()
    {
        $this->assertFalse(Boolean::doEq(true, false));
        $this->assertFalse(Boolean::doEq(false, true));
        $this->assertTrue(Boolean::doEq(true, true));
        $this->assertTrue(Boolean::doEq(false, false));

        $this->assertEquals([true, false, true], Boolean::doEq([true, true, false], [true, false, false]));
    }

    /**
     * Tests PrimitiveBoolean::doXor()
     *
     * @depends test_doEq
     */
    public function test_doXor()
    {
        $this->assertTrue(Boolean::doXor(true, false));
        $this->assertTrue(Boolean::doXor(false, true));
        $this->assertFalse(Boolean::doXor(true, true));
        $this->assertFalse(Boolean::doXor(false, false));

        $this->assertEquals([false, true, false], Boolean::doXor([true, true, false], [true, false, false]));
    }
}
