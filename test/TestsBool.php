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

use axelitus\Base\Bool;

/**
 * Class TestsBool
 *
 * @package axelitus\Base
 */
class TestsBool extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(Bool::is(true));
        $this->assertTrue(Bool::is(false));
        $this->assertTrue(Bool::is(1));
        $this->assertTrue(Bool::is(0));
        $this->assertFalse(Bool::is('true'));
        $this->assertFalse(Bool::is('false'));
        $this->assertFalse(Bool::is('on'));
        $this->assertFalse(Bool::is('off'));
        $this->assertFalse(Bool::is('yes'));
        $this->assertFalse(Bool::is('no'));
        $this->assertFalse(Bool::is('y'));
        $this->assertFalse(Bool::is('n'));
        $this->assertFalse(Bool::is('1'));
        $this->assertFalse(Bool::is('0'));
        $this->assertFalse(Bool::is('string'));
        $this->assertFalse(Bool::is(10));
        $this->assertFalse(Bool::is(-10));
    }

    public function testExtIs()
    {
        $this->assertTrue(Bool::extIs(true));
        $this->assertTrue(Bool::extIs(false));
        $this->assertTrue(Bool::extIs(1));
        $this->assertTrue(Bool::extIs(0));
        $this->assertTrue(Bool::extIs('true'));
        $this->assertTrue(Bool::extIs('false'));
        $this->assertTrue(Bool::extIs('on'));
        $this->assertTrue(Bool::extIs('off'));
        $this->assertTrue(Bool::extIs('yes'));
        $this->assertTrue(Bool::extIs('no'));
        $this->assertTrue(Bool::extIs('y'));
        $this->assertTrue(Bool::extIs('n'));
        $this->assertTrue(Bool::extIs('1'));
        $this->assertTrue(Bool::extIs('0'));
        $this->assertFalse(Bool::extIs('string'));
        $this->assertFalse(Bool::extIs(10));
        $this->assertFalse(Bool::extIs(-10));
    }

    public function testIsTrueStr()
    {
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['true']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['1']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['on']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['yes']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['y']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', ['string']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStr', [1]));
    }

    public function testIsTrueStrExt()
    {
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['true']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['1']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['on']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['yes']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['y']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', ['string']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isTrueStrExt', [1]));
    }

    public function testIsFalseStr()
    {
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['false']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['0']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['off']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['no']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['n']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', ['string']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStr', [0]));
    }

    public function testIsFalseStrExt()
    {
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['false']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['0']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['off']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['no']));
        $this->assertTrue($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['n']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', ['string']));
        $this->assertFalse($this->execNonPublicMethod('axelitus\Base\Bool', 'isFalseStrExt', [0]));
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertEquals(-1, Bool::compare(false, true));
        $this->assertEquals(0, Bool::compare(false, false));
        $this->assertEquals(0, Bool::compare(true, true));
        $this->assertEquals(1, Bool::compare(true, false));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$bool1 and \$bool2 parameters must be of type bool."
        );
        Bool::compare('string', true);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$bool1 and \$bool2 parameters must be of type bool."
        );
        Bool::compare(true, 'string');
    }

    // endregion

    // region: Conversion

    public function testFrom()
    {
        $this->assertTrue(Bool::From('yes'));
        $this->assertTrue(Bool::From('1'));
        $this->assertTrue(Bool::From('true'));
        $this->assertTrue(Bool::From('y'));
        $this->assertTrue(Bool::From('on'));

        $this->assertFalse(Bool::From('no'));
        $this->assertFalse(Bool::From('0'));
        $this->assertFalse(Bool::From('false'));
        $this->assertFalse(Bool::From('n'));
        $this->assertFalse(Bool::From('off'));

        $this->assertEquals(null, Bool::From('string'));
        $this->assertEquals(true, Bool::From('string', true));
        $this->assertEquals(false, Bool::From('string', false));
    }

    // endregion

    // region: Parsing

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
        Bool::parse(9);
    }

    public function testParseEx02()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The \$input string cannot be parsed because it does not match 'true', 'false', '1' or '0'."
        );
        Bool::parse('yes');
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
        Bool::extParse(9);
    }

    public function testExtParseEx02()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The \$input parameter did not match any of the valid strings that can be parsed."
        );
        Bool::extParse('valid');
    }

    // endregion
}
