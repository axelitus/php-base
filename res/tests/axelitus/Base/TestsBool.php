<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.6.0
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
    //region Value Testing

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

    //endregion

    //region Conversion

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

    //endregion

    //region NOT operation

    public function testValueNot()
    {
        $this->assertTrue(Bool::valueNot(false));
        $this->assertFalse(Bool::valueNot(true));
        $this->assertEquals([true, false], Bool::valueNot(false, true));
        $this->assertEquals([false, true, true], Bool::valueNot(true, false, false));
        $this->assertEquals([true, false, false, true, false], Bool::valueNot(false, true, true, false, true));
    }

    public function testValueNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::valueNot(true, true, 'string');
    }

    public function testArrayNot()
    {
        $this->assertEquals([true], Bool::arrayNot([false]));
        $this->assertEquals([false], Bool::arrayNot([true]));
        $this->assertEquals([true, false], Bool::arrayNot([false, true]));
        $this->assertEquals([false, true, true], Bool::arrayNot([true, false, false]));
        $this->assertEquals([true, false, false, true, false], Bool::arrayNot([false, true, true, false, true]));
    }

    public function testArrayNotEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type array.");
        Bool::arrayNot([true, true], [false, false], 'string');
    }

    public function testArrayNotEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::arrayNot([true, true, false, false, 'string']);
    }

    //endregion

    //region AND operation

    public function testValueAnd()
    {
        $this->assertTrue(Bool::valueAnd(true, true));
        $this->assertFalse(Bool::valueAnd(true, false));
        $this->assertTrue(Bool::valueAnd(true, true, true, true, true));
        $this->assertFalse(Bool::valueAnd(true, true, true, false, true));
    }

    public function testValueAndEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::valueAnd(true, 'string');
    }

    public function testValueAndEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::valueAnd(true, true, true, 'string');
    }

    public function testArrayAnd()
    {
        $this->assertTrue(Bool::arrayAnd([true, true]));
        $this->assertFalse(Bool::arrayAnd([true, false]));
        $this->assertTrue(Bool::arrayAnd([true, true, true, true, true]));
        $this->assertFalse(Bool::arrayAnd([true, true, true, false, true]));

        $this->assertEquals(
            [true, false, false, true],
            Bool::arrayAnd([true, true, true], [true, false, true], [false, false, true], [true, true, true])
        );
    }

    public function testArrayAndEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        Bool::arrayAnd([true, true], [true, false], 'string');
    }

    public function testArrayAndEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        Bool::arrayAnd([true, true], [true, false], [true]);
    }

    public function testArrayAndEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::arrayAnd([true, true, true], [true, true, 'string']);
    }

    //endregion

    //region AND operation

    public function testValueOr()
    {
        $this->assertTrue(Bool::valueOr(true, true));
        $this->assertTrue(Bool::valueOr(true, false));
        $this->assertTrue(Bool::valueOr(false, false, true, false, false));
        $this->assertFalse(Bool::valueOr(false, false));
        $this->assertFalse(Bool::valueOr(false, false, false, false, false));
    }

    public function testValueOrEx01()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::valueOr(true, 'string');
    }

    public function testValueOrEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::valueOr(false, false, false, 'string');
    }

    public function testArrayOr()
    {
        $this->assertTrue(Bool::arrayOr([true, true]));
        $this->assertTrue(Bool::arrayOr([true, false]));
        $this->assertTrue(Bool::arrayOr([false, false, true, false, false]));
        $this->assertFalse(Bool::arrayOr([false, false]));
        $this->assertFalse(Bool::arrayOr([false, false, false, false, false]));

        $this->assertEquals(
            [true, false, false, true],
            Bool::arrayOr([true, false, false], [false, false, false], [false, false, false], [false, true, true])
        );
    }

    public function testArrayOrEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        Bool::arrayOr([true, true], [true, false], 'string');
    }

    public function testArrayOrEx02()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "All parameters must be of type array and must contain at least 2 items."
        );
        Bool::arrayOr([true, true], [true, false], [true]);
    }

    public function testArrayOrEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "All parameters must be of type bool.");
        Bool::arrayOr([false, false, false], [false, false, 'string']);
    }

    //endregion

    //region EQ operation

    public function testOpEq()
    {
        $this->assertTrue(Bool::opEq(false, false));
        $this->assertFalse(Bool::opEq(false, true));
        $this->assertFalse(Bool::opEq(true, false));
        $this->assertTrue(Bool::opEq(true, true));

        $this->assertTrue(Bool::opEq([false, false]));
        $this->assertFalse(Bool::opEq([false, true]));
        $this->assertFalse(Bool::opEq([true, false]));
        $this->assertTrue(Bool::opEq([true, true]));

        $this->assertEquals(
            [true, false, false, true],
            Bool::opEq([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testOpEqEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot mix value types. All values must be of the same type (in this case array)."
        );
        Bool::opEq([true, true], true);
    }

    public function testOpEqEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opEq([true, 'string']);
    }

    public function testOpEqEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "Only two booleans at a time are allowed.");
        Bool::opEq(true, true, true);
    }

    public function testOpEqEx04()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot mix value types. All values must be of the same type (in this case bool)."
        );
        Bool::opEq(true, [true, true]);
    }

    public function testOpEqEx05()
    {
        $this->setExpectedException('\InvalidArgumentException', "All values must be of type bool or array.");
        Bool::opEq(5, 'string');
    }

    //endregion

    //region XOR operation

    public function testOpXor()
    {
        $this->assertFalse(Bool::opXor(false, false));
        $this->assertTrue(Bool::opXor(false, true));
        $this->assertTrue(Bool::opXor(true, false));
        $this->assertFalse(Bool::opXor(true, true));

        $this->assertFalse(Bool::opXor([false, false]));
        $this->assertTrue(Bool::opXor([false, true]));
        $this->assertTrue(Bool::opXor([true, false]));
        $this->assertFalse(Bool::opXor([true, true]));

        $this->assertEquals(
            [false, true, true, false],
            Bool::opXor([false, false], [false, true], [true, false], [true, true])
        );
    }

    public function testOpXorEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot mix value types. All values must be of the same type (in this case array)."
        );
        Bool::opXor([true, true], true);
    }

    public function testOpXorEx02()
    {
        $this->setExpectedException('\InvalidArgumentException', "All array values must be of type bool.");
        Bool::opXor([true, 'string']);
    }

    public function testOpXorEx03()
    {
        $this->setExpectedException('\InvalidArgumentException', "Only two booleans at a time are allowed.");
        Bool::opXor(true, true, true);
    }

    public function testOpXorEx04()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "Cannot mix value types. All values must be of the same type (in this case bool)."
        );
        Bool::opXor(true, [true, true]);
    }

    public function testOpXorEx05()
    {
        $this->setExpectedException('\InvalidArgumentException', "All values must be of type bool or array.");
        Bool::opXor(5, 'string');
    }

    //endregion
}
