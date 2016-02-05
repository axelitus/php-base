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

use axelitus\Base\ABool;

/**
 * Class TestsABool
 *
 * @package axelitus\Base
 */
class TestsABool extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(ABool::is(true));
        $this->assertTrue(ABool::is(false));
        $this->assertTrue(ABool::is(1));
        $this->assertTrue(ABool::is(0));
        $this->assertFalse(ABool::is('true'));
        $this->assertFalse(ABool::is('false'));
        $this->assertFalse(ABool::is('on'));
        $this->assertFalse(ABool::is('off'));
        $this->assertFalse(ABool::is('yes'));
        $this->assertFalse(ABool::is('no'));
        $this->assertFalse(ABool::is('y'));
        $this->assertFalse(ABool::is('n'));
        $this->assertFalse(ABool::is('1'));
        $this->assertFalse(ABool::is('0'));
        $this->assertFalse(ABool::is('string'));
        $this->assertFalse(ABool::is(10));
        $this->assertFalse(ABool::is(-10));
    }

    public function testExtIs()
    {
        $this->assertTrue(ABool::extIs(true));
        $this->assertTrue(ABool::extIs(false));
        $this->assertTrue(ABool::extIs(1));
        $this->assertTrue(ABool::extIs(0));
        $this->assertTrue(ABool::extIs('true'));
        $this->assertTrue(ABool::extIs('false'));
        $this->assertTrue(ABool::extIs('on'));
        $this->assertTrue(ABool::extIs('off'));
        $this->assertTrue(ABool::extIs('yes'));
        $this->assertTrue(ABool::extIs('no'));
        $this->assertTrue(ABool::extIs('y'));
        $this->assertTrue(ABool::extIs('n'));
        $this->assertTrue(ABool::extIs('1'));
        $this->assertTrue(ABool::extIs('0'));
        $this->assertFalse(ABool::extIs('string'));
        $this->assertFalse(ABool::extIs(10));
        $this->assertFalse(ABool::extIs(-10));
    }

    public function testIsTrueStr()
    {
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['true']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['1']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['on']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['yes']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['y']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStr', ['string']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStr', [1]));
    }

    public function testIsTrueStrExt()
    {
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['true']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['1']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['on']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['yes']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['y']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', ['string']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isTrueStrExt', [1]));
    }

    public function testIsFalseStr()
    {
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['false']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['0']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['off']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['no']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['n']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStr', ['string']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStr', [0]));
    }

    public function testIsFalseStrExt()
    {
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['false']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['0']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['off']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['no']));
        $this->assertTrue($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['n']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', ['string']));
        $this->assertFalse($this->execNonPublicMethod(ABool::class, 'isFalseStrExt', [0]));
    }

    // endregion

    // region: Comparing

    public function testCompare()
    {
        $this->assertEquals(-1, ABool::compare(false, true));
        $this->assertEquals(0, ABool::compare(false, false));
        $this->assertEquals(0, ABool::compare(true, true));
        $this->assertEquals(1, ABool::compare(true, false));
    }

    public function testCompareEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$bool1 and \$bool2 parameters must be of type bool."
        );
        ABool::compare('string', true);
    }

    public function testCompareEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$bool1 and \$bool2 parameters must be of type bool."
        );
        ABool::compare(true, 'string');
    }

    // endregion

    // region: Conversion

    public function testFrom()
    {
        $this->assertTrue(ABool::From('yes'));
        $this->assertTrue(ABool::From('1'));
        $this->assertTrue(ABool::From('true'));
        $this->assertTrue(ABool::From('y'));
        $this->assertTrue(ABool::From('on'));

        $this->assertFalse(ABool::From('no'));
        $this->assertFalse(ABool::From('0'));
        $this->assertFalse(ABool::From('false'));
        $this->assertFalse(ABool::From('n'));
        $this->assertFalse(ABool::From('off'));

        $this->assertEquals(null, ABool::From('string'));
        $this->assertEquals(true, ABool::From('string', true));
        $this->assertEquals(false, ABool::From('string', false));
    }

    // endregion

    // region: Parsing

    public function testParse()
    {
        $this->assertTrue(ABool::parse('true'));
        $this->assertFalse(ABool::parse('false'));
        $this->assertTrue(ABool::parse('1'));
        $this->assertFalse(ABool::parse('0'));
    }

    public function testParseEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$input parameter must be a non-empty string.");
        ABool::parse(9);
    }

    public function testParseEx02()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The \$input string cannot be parsed because it does not match 'true', 'false', '1' or '0'."
        );
        ABool::parse('yes');
    }

    public function testExtParse()
    {
        $this->assertTrue(ABool::extParse('true'));
        $this->assertTrue(ABool::extParse('TRUE'));
        $this->assertTrue(ABool::extParse('on'));
        $this->assertTrue(ABool::extParse('ON'));
        $this->assertTrue(ABool::extParse('yes'));
        $this->assertTrue(ABool::extParse('Yes'));
        $this->assertTrue(ABool::extParse('y'));
        $this->assertTrue(ABool::extParse('Y'));
        $this->assertTrue(ABool::extParse('1'));
        $this->assertFalse(ABool::extParse('false'));
        $this->assertFalse(ABool::extParse('FALSE'));
        $this->assertFalse(ABool::extParse('off'));
        $this->assertFalse(ABool::extParse('OFF'));
        $this->assertFalse(ABool::extParse('no'));
        $this->assertFalse(ABool::extParse('No'));
        $this->assertFalse(ABool::extParse('n'));
        $this->assertFalse(ABool::extParse('N'));
        $this->assertFalse(ABool::extParse('0'));
    }

    public function testExtParseEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "The \$input parameter must be a non-empty string.");
        ABool::extParse(9);
    }

    public function testExtParseEx02()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The \$input parameter did not match any of the valid strings that can be parsed."
        );
        ABool::extParse('valid');
    }

    // endregion
}
