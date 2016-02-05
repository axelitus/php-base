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

use axelitus\Base\AStr;

/**
 * Class TestsAStr
 *
 * @package axelitus\Base
 */
class TestsAStr extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(AStr::is('string'));
        $this->assertFalse(AStr::is(9));
        $this->assertFalse(AStr::is(['array']));
    }

    public function testIsAndEmpty()
    {
        $this->assertTrue(AStr::isAndEmpty(''));
        $this->assertFalse(AStr::isAndEmpty(5));
        $this->assertFalse(AStr::isAndEmpty('not empty'));
    }

    public function testIsAndNotEmpty()
    {
        $this->assertTrue(AStr::isAndNotEmpty('not empty'));
        $this->assertFalse(AStr::isAndNotEmpty(5));
        $this->assertFalse(AStr::isAndNotEmpty(''));
    }

    public function testIsNotOrEmpty()
    {
        $this->assertTrue(AStr::isNotOrEmpty(5));
        $this->assertTrue(AStr::isNotOrEmpty(''));
        $this->assertFalse(AStr::isNotOrEmpty('not empty'));
    }

    public function testIsNotOrNotEmpty()
    {
        $this->assertTrue(AStr::isNotOrNotEmpty(5));
        $this->assertTrue(AStr::isNotOrNotEmpty('not empty'));
        $this->assertFalse(AStr::isNotOrNotEmpty(''));
    }

    // endregion

    // region: Comparison

    public function testCompare()
    {
        $this->assertLessThan(0, AStr::compare('abc', 'def'));
        $this->assertEquals(0, AStr::compare('abc', 'abc'));
        $this->assertGreaterThan(0, AStr::compare('def', 'abc'));

        $this->assertLessThan(0, AStr::compare('ABC', 'abc'));
        $this->assertGreaterThan(0, AStr::compare('def', 'DEF'));

        $this->assertEquals(0, AStr::compare('ABC', 'abc', true));
        $this->assertEquals(0, AStr::compare('def', 'DEF', true));
    }

    public function testEquals()
    {
        $this->assertFalse(AStr::equals('abc', 'def'));
        $this->assertTrue(AStr::equals('abc', 'abc'));
        $this->assertFalse(AStr::equals('def', 'abc'));

        $this->assertFalse(AStr::equals('ABC', 'abc'));
        $this->assertFalse(AStr::equals('def', 'DEF'));

        $this->assertTrue(AStr::equals('ABC', 'abc', true));
        $this->assertTrue(AStr::equals('def', 'DEF', true));
    }

    public function testContains()
    {
        $this->assertTrue(AStr::contains('abcdef', 'ab'));
        $this->assertTrue(AStr::contains('abcdef', 'cde'));
        $this->assertFalse(AStr::contains('abcdef', 'cDe'));
        $this->assertTrue(AStr::contains('abcdef', 'cDe', true));
        $this->assertFalse(AStr::contains('abcdef', 'efg'));
    }

    public function testBeginsWith()
    {
        $this->assertTrue(AStr::beginsWith('abcdef', 'abc'));
        $this->assertFalse(AStr::beginsWith('abcdef', 'Abc'));
        $this->assertTrue(AStr::beginsWith('abcdef', 'Abc', true));
        $this->assertFalse(AStr::beginsWith('abcdef', 'bcd'));
        $this->assertTrue(AStr::beginsWith('abcdef', 'abcdef'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(AStr::endsWith('abcdef', 'def'));
        $this->assertFalse(AStr::endsWith('abcdef', 'deF'));
        $this->assertTrue(AStr::endsWith('abcdef', 'deF', true));
        $this->assertFalse(AStr::endsWith('abcdef', 'cde'));
        $this->assertTrue(AStr::endsWith('abcdef', 'abcdef'));
        $this->assertTrue(AStr::endsWith('abcdef', ''));
    }

    public function testIsOneOf()
    {
        $values = ['apple', 'banana', 'grapes', 'oranges'];
        $this->assertTrue(AStr::isOneOf('apple', $values));
        $this->assertFalse(AStr::isOneOf('Apple', $values));
        $this->assertTrue(AStr::isOneOf('Apple', $values, true));
        $this->assertTrue(AStr::isOneOf('oranges', $values));
    }

    public function testMatch()
    {
        $this->assertEquals(1, AStr::match('abcdefghijklmnop', '/.*/'));
        $this->assertEquals(0, AStr::match('abcdefghijklmnop', '/ponmlkjihgfedcba/'));
    }

    // endregion

    // region: Length

    public function testLength()
    {
        $this->assertEquals(3, AStr::length('abc'));
        $this->assertEquals(5, AStr::length('abcde'));
    }

    // endregion

    // region: Extraction

    public function testSub()
    {
        $this->assertEquals('def', AStr::sub('abcdef', 3));
        $this->assertEquals('abc', AStr::sub('abcdef', 0, 3));
        $this->assertEquals('ef', AStr::sub('abcdef', -2));
    }

    public function testPos()
    {
        $this->assertEquals(2, AStr::pos('abcdef', 'c'));
        $this->assertFalse(AStr::pos('abcdef', 'C'));
        $this->assertEquals(4, AStr::pos('abcdef', 'E', true));
    }

    // endregion

    // region: Replace

    public function testReplace()
    {
        $this->assertEquals('abghif', AStr::replace('abcdef', 'cde', 'ghi'));
        $this->assertEquals('abghijklf', AStr::replace('abcdef', 'cde', 'ghijkl'));
        $this->assertEquals('ghidef', AStr::replace('abcdef', 'abc', 'ghi'));
        $this->assertEquals('abcghi', AStr::replace('abcdef', 'def', 'ghi'));
        $this->assertEquals('ghijkl', AStr::replace('abcdef', 'abcdef', 'ghijkl'));
        $this->assertEquals('ghijkl', AStr::replace('aBcDEf', 'abcdef', 'ghijkl', true));
    }

    public function testMbStrReplaceCaller()
    {
        $expected = ['String A to replace.', 'String B to replace.'];
        $actual = $this->execNonPublicMethod(
            AStr::class,
            'mbStrReplaceCaller',
            ['change', 'replace', ['String A to change.', 'String B to change.']]
        );
        $this->assertEquals($expected, $actual);

        $expected = 'To replace the string some values will be replaced.';
        $actual = $this->execNonPublicMethod(
            AStr::class,
            'mbStrReplaceCaller',
            [['change', 'modify'], 'replace', 'To modify the string some values will be changed.']
        );
        $this->assertEquals($expected, $actual);

        $expected = 'String not changed.';
        $actual = $this->execNonPublicMethod(
            AStr::class,
            'mbStrReplaceCaller',
            ['none', 'replace', 'String not changed.']
        );
        $this->assertEquals($expected, $actual);

        $count = 0;
        $expected = 'One replacement. Two replacements. Three replacements.';
        $actual = $this->execNonPublicMethod(
            AStr::class,
            'mbStrReplaceCaller',
            ['change', 'replacement', 'One change. Two changes. Three changes.', false, AStr::DEFAULT_ENCODING, &$count]
        );
        $this->assertEquals($expected, $actual);
        $this->assertEquals(3, $count);
    }

    public function testTruncate()
    {
        $this->assertEquals('abcdefghijklmnop', AStr::truncate('abcdefghijklmnop', AStr::length('abcdefghijklmnop')));
        $this->assertEquals('abcde...', AStr::truncate('abcdefghijklmnop', 5));
        $this->assertEquals('abcdefghi -> more', AStr::truncate('abcdefghijklmnop', 9, ' -> more'));
        $this->assertEquals('...', AStr::truncate('abcdefghijklmnop', 0));
        $this->assertEquals(
            '<span>abc<strong>de...</strong></span>',
            AStr::truncate('<span>abc<strong>defghi</strong>jklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>de...</strong></span>',
            AStr::truncate('<span>abc<strong>de</strong>fghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>d</strong>e...</span>',
            AStr::truncate('<span>abc<strong>d</strong>efghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>a&nbsp;bc<strong>d...</strong></span>',
            AStr::truncate('<span>a&nbsp;bc<strong>d</strong>efghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>d...</strong></span>',
            AStr::truncate('<span>abc<strong>d&nbsp;</strong>efghijklmnop</span>', 4, '...', true)
        );
        $this->assertEquals(
            '<span>a&nbsp;bc<strong>d</strong>ef&nbsp;ghi...</span>',
            AStr::truncate('<span>a&nbsp;bc<strong>d</strong>ef&nbsp;ghijklmnop</span>', 11, '...', true)
        );
    }

    // endregion

    // region: Transforms

    public function testLower()
    {
        $this->assertEquals('abcdef', AStr::lower('Abcdef'));
        $this->assertEquals('abcdef', AStr::lower('AbcDef'));
        $this->assertEquals('abcdef', AStr::lower('AbcdeF'));
        $this->assertEquals('abcdef', AStr::lower('ABCDEF'));
    }

    public function testUpper()
    {
        $this->assertEquals('ABCDEF', AStr::upper('Abcdef'));
        $this->assertEquals('ABCDEF', AStr::upper('AbcDef'));
        $this->assertEquals('ABCDEF', AStr::upper('AbcdeF'));
        $this->assertEquals('ABCDEF', AStr::upper('abcdef'));
    }

    public function testLcfirst()
    {
        $this->assertEquals('abcdef', AStr::lcfirst('Abcdef'));
        $this->assertEquals('abcDef', AStr::lcfirst('AbcDef'));
        $this->assertEquals('abcdeF', AStr::lcfirst('AbcdeF'));
        $this->assertEquals('aBCDEF', AStr::lcfirst('ABCDEF'));
        $this->assertEquals('abcdef', AStr::lcfirst('abcdef'));
    }

    public function testUcfirst()
    {
        $this->assertEquals('Abcdef', AStr::ucfirst('abcdef'));
        $this->assertEquals('AbcDef', AStr::ucfirst('abcDef'));
        $this->assertEquals('AbcdeF', AStr::ucfirst('abcdeF'));
        $this->assertEquals('ABCDEF', AStr::ucfirst('ABCDEF'));
        $this->assertEquals('Abcdef', AStr::ucfirst('abcdef'));
    }

    public function testUcwords()
    {
        $this->assertEquals('Abc Def Ghijk Lmno', AStr::ucwords('abc def ghijk lmno'));
        $this->assertEquals('A Bc Def Ghij Klmno', AStr::ucwords('a bc def ghij klmno'));
        $this->assertEquals('A Bcdefghi Jklmno', AStr::ucwords('a bcdefghi jklmno'));
    }

    // endregion

    // region: Style Transforms

    public function testStudly()
    {
        $this->assertEquals('a_bc_def', AStr::studly("a_bc_def", []));
        $this->assertEquals('ABcDef', AStr::studly("a_bc_def"));
        $this->assertEquals('AbCdEfGh', AStr::studly("ab.cd_ef,gh", ['_', '.', ',']));
    }

    public function testCamel()
    {
        $this->assertEquals('a_bc_def', AStr::camel("a_bc_def", []));
        $this->assertEquals('aBcDef', AStr::camel("a_bc_def"));
        $this->assertEquals('abCdEfGh', AStr::camel("ab.cd_ef,gh", ['_', '.', ',']));
    }

    public function testSeparated()
    {
        $this->assertEquals('abc_Def_Ghi', AStr::separated("abcDefGhi"));
        $this->assertEquals('Abc-Def-Ghi', AStr::separated("AbcDefGhi", '-'));
        $this->assertEquals('abc-def-ghi', AStr::separated("AbcDefGhi", '-', 'lower'));
        $this->assertEquals('ABC-DEF-GHI', AStr::separated("AbcDefGhi", '-', 'upper'));
        $this->assertEquals('abc-Def-Ghi', AStr::separated("AbcDefGhi", '-', 'lcfirst'));
        $this->assertEquals('Abc-Def-Ghi', AStr::separated("abcDefGhi", '-', 'ucfirst'));
        $this->assertEquals('Abc-def-ghi', AStr::separated("AbcDefGhi", '-', 'ucwords'));
    }

    public function testSeparatedEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$separator parameter must be a non-empty string."
        );
        AStr::separated('abcDefGhi', '');
    }

    // endregion

    // region: Formatting

    public function testNsprintf()
    {
        $this->assertEquals('abcdef', AStr::nsprintf('a%letter$scdef', ['letter' => 'b']));
        $this->assertEquals('abcdef', AStr::nsprintf('a%ltr1$scd%ltr2$sf', ['ltr1' => 'b', 'ltr2' => 'e']));
    }

    public function testNsprintfEx01()
    {
        $this->setExpectedException('\BadFunctionCallException');
        AStr::nsprintf('a%ltr1$scd%ltr2$sf', ['ltr1' => 'b']);
    }

    // endregion
}
