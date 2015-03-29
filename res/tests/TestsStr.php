<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Str;

/**
 * Class TestsString
 *
 * @package axelitus\Base
 */
class TestsString extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(Str::is('string'));
        $this->assertFalse(Str::is(9));
        $this->assertFalse(Str::is(['array']));
    }

    public function testIsAndEmpty()
    {
        $this->assertTrue(Str::isAndEmpty(''));
        $this->assertFalse(Str::isAndEmpty(5));
        $this->assertFalse(Str::isAndEmpty('not empty'));
    }

    public function testIsAndNotEmpty()
    {
        $this->assertTrue(Str::isAndNotEmpty('not empty'));
        $this->assertFalse(Str::isAndNotEmpty(5));
        $this->assertFalse(Str::isAndNotEmpty(''));
    }

    public function testIsNotOrEmpty()
    {
        $this->assertTrue(Str::isNotOrEmpty(5));
        $this->assertTrue(Str::isNotOrEmpty(''));
        $this->assertFalse(Str::isNotOrEmpty('not empty'));
    }

    public function testIsNotOrNotEmpty()
    {
        $this->assertTrue(Str::isNotOrNotEmpty(5));
        $this->assertTrue(Str::isNotOrNotEmpty('not empty'));
        $this->assertFalse(Str::isNotOrNotEmpty(''));
    }

    // endregion

    // region: Comparison

    public function testCompare()
    {
        $this->assertLessThan(0, Str::compare('abc', 'def'));
        $this->assertEquals(0, Str::compare('abc', 'abc'));
        $this->assertGreaterThan(0, Str::compare('def', 'abc'));

        $this->assertLessThan(0, Str::compare('ABC', 'abc'));
        $this->assertGreaterThan(0, Str::compare('def', 'DEF'));

        $this->assertEquals(0, Str::compare('ABC', 'abc', true));
        $this->assertEquals(0, Str::compare('def', 'DEF', true));
    }

    public function testEquals()
    {
        $this->assertFalse(Str::equals('abc', 'def'));
        $this->assertTrue(Str::equals('abc', 'abc'));
        $this->assertFalse(Str::equals('def', 'abc'));

        $this->assertFalse(Str::equals('ABC', 'abc'));
        $this->assertFalse(Str::equals('def', 'DEF'));

        $this->assertTrue(Str::equals('ABC', 'abc', true));
        $this->assertTrue(Str::equals('def', 'DEF', true));
    }

    public function testContains()
    {
        $this->assertTrue(Str::contains('abcdef', 'ab'));
        $this->assertTrue(Str::contains('abcdef', 'cde'));
        $this->assertFalse(Str::contains('abcdef', 'cDe'));
        $this->assertTrue(Str::contains('abcdef', 'cDe', true));
        $this->assertFalse(Str::contains('abcdef', 'efg'));
    }

    public function testBeginsWith()
    {
        $this->assertTrue(Str::beginsWith('abcdef', 'abc'));
        $this->assertFalse(Str::beginsWith('abcdef', 'Abc'));
        $this->assertTrue(Str::beginsWith('abcdef', 'Abc', true));
        $this->assertFalse(Str::beginsWith('abcdef', 'bcd'));
        $this->assertTrue(Str::beginsWith('abcdef', 'abcdef'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(Str::endsWith('abcdef', 'def'));
        $this->assertFalse(Str::endsWith('abcdef', 'deF'));
        $this->assertTrue(Str::endsWith('abcdef', 'deF', true));
        $this->assertFalse(Str::endsWith('abcdef', 'cde'));
        $this->assertTrue(Str::endsWith('abcdef', 'abcdef'));
        $this->assertTrue(Str::endsWith('abcdef', ''));
    }

    public function testIsOneOf()
    {
        $values = ['apple', 'banana', 'grapes', 'oranges'];
        $this->assertTrue(Str::isOneOf('apple', $values));
        $this->assertFalse(Str::isOneOf('Apple', $values));
        $this->assertTrue(Str::isOneOf('Apple', $values, true));
        $this->assertTrue(Str::isOneOf('oranges', $values));
    }

    public function testMatch()
    {
        $this->assertEquals(1, Str::match('abcdefghijklmnop', '/.*/'));
        $this->assertEquals(0, Str::match('abcdefghijklmnop', '/ponmlkjihgfedcba/'));
    }

    // endregion

    // region: Length

    public function testLength()
    {
        $this->assertEquals(3, Str::length('abc'));
        $this->assertEquals(5, Str::length('abcde'));
    }

    // endregion

    // region: Extraction

    public function testSub()
    {
        $this->assertEquals('def', Str::sub('abcdef', 3));
        $this->assertEquals('abc', Str::sub('abcdef', 0, 3));
        $this->assertEquals('ef', Str::sub('abcdef', -2));
    }

    public function testPos()
    {
        $this->assertEquals(2, Str::pos('abcdef', 'c'));
        $this->assertFalse(Str::pos('abcdef', 'C'));
        $this->assertEquals(4, Str::pos('abcdef', 'E', true));
    }

    // endregion

    // region: Replace

    public function testReplace()
    {
        $this->assertEquals('abghif', Str::replace('abcdef', 'cde', 'ghi'));
        $this->assertEquals('abghijklf', Str::replace('abcdef', 'cde', 'ghijkl'));
        $this->assertEquals('ghidef', Str::replace('abcdef', 'abc', 'ghi'));
        $this->assertEquals('abcghi', Str::replace('abcdef', 'def', 'ghi'));
        $this->assertEquals('ghijkl', Str::replace('abcdef', 'abcdef', 'ghijkl'));
        $this->assertEquals('ghijkl', Str::replace('aBcDEf', 'abcdef', 'ghijkl', true));
    }

    public function testMbStrReplaceCaller()
    {
        $expected = ['String A to replace.', 'String B to replace.'];
        $actual = $this->execNonPublicMethod(
            'axelitus\Base\Str',
            'mbStrReplaceCaller',
            ['change', 'replace', ['String A to change.', 'String B to change.']]
        );
        $this->assertEquals($expected, $actual);

        $expected = 'To replace the string some values will be replaced.';
        $actual = $this->execNonPublicMethod(
            'axelitus\Base\Str',
            'mbStrReplaceCaller',
            [['change', 'modify'], 'replace', 'To modify the string some values will be changed.']
        );
        $this->assertEquals($expected, $actual);

        $expected = 'String not changed.';
        $actual = $this->execNonPublicMethod(
            'axelitus\Base\Str',
            'mbStrReplaceCaller',
            ['none', 'replace', 'String not changed.']
        );
        $this->assertEquals($expected, $actual);

        $count = 0;
        $expected = 'One replacement. Two replacements. Three replacements.';
        $actual = $this->execNonPublicMethod(
            'axelitus\Base\Str',
            'mbStrReplaceCaller',
            ['change', 'replacement', 'One change. Two changes. Three changes.', false, Str::DEFAULT_ENCODING, &$count]
        );
        $this->assertEquals($expected, $actual);
        $this->assertEquals(3, $count);
    }

    public function testTruncate()
    {
        $this->assertEquals('abcdefghijklmnop', Str::truncate('abcdefghijklmnop', Str::length('abcdefghijklmnop')));
        $this->assertEquals('abcde...', Str::truncate('abcdefghijklmnop', 5));
        $this->assertEquals('abcdefghi -> more', Str::truncate('abcdefghijklmnop', 9, ' -> more'));
        $this->assertEquals('...', Str::truncate('abcdefghijklmnop', 0));
        $this->assertEquals(
            '<span>abc<strong>de...</strong></span>',
            Str::truncate('<span>abc<strong>defghi</strong>jklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>de...</strong></span>',
            Str::truncate('<span>abc<strong>de</strong>fghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>d</strong>e...</span>',
            Str::truncate('<span>abc<strong>d</strong>efghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>a&nbsp;bc<strong>d...</strong></span>',
            Str::truncate('<span>a&nbsp;bc<strong>d</strong>efghijklmnop</span>', 5, '...', true)
        );
        $this->assertEquals(
            '<span>abc<strong>d...</strong></span>',
            Str::truncate('<span>abc<strong>d&nbsp;</strong>efghijklmnop</span>', 4, '...', true)
        );
        $this->assertEquals(
            '<span>a&nbsp;bc<strong>d</strong>ef&nbsp;ghi...</span>',
            Str::truncate('<span>a&nbsp;bc<strong>d</strong>ef&nbsp;ghijklmnop</span>', 11, '...', true)
        );
    }

    // endregion

    // region: Transforms

    public function testLower()
    {
        $this->assertEquals('abcdef', Str::lower('Abcdef'));
        $this->assertEquals('abcdef', Str::lower('AbcDef'));
        $this->assertEquals('abcdef', Str::lower('AbcdeF'));
        $this->assertEquals('abcdef', Str::lower('ABCDEF'));
    }

    public function testUpper()
    {
        $this->assertEquals('ABCDEF', Str::upper('Abcdef'));
        $this->assertEquals('ABCDEF', Str::upper('AbcDef'));
        $this->assertEquals('ABCDEF', Str::upper('AbcdeF'));
        $this->assertEquals('ABCDEF', Str::upper('abcdef'));
    }

    public function testLcfirst()
    {
        $this->assertEquals('abcdef', Str::lcfirst('Abcdef'));
        $this->assertEquals('abcDef', Str::lcfirst('AbcDef'));
        $this->assertEquals('abcdeF', Str::lcfirst('AbcdeF'));
        $this->assertEquals('aBCDEF', Str::lcfirst('ABCDEF'));
        $this->assertEquals('abcdef', Str::lcfirst('abcdef'));
    }

    public function testUcfirst()
    {
        $this->assertEquals('Abcdef', Str::ucfirst('abcdef'));
        $this->assertEquals('AbcDef', Str::ucfirst('abcDef'));
        $this->assertEquals('AbcdeF', Str::ucfirst('abcdeF'));
        $this->assertEquals('ABCDEF', Str::ucfirst('ABCDEF'));
        $this->assertEquals('Abcdef', Str::ucfirst('abcdef'));
    }

    public function testUcwords()
    {
        $this->assertEquals('Abc Def Ghijk Lmno', Str::ucwords('abc def ghijk lmno'));
        $this->assertEquals('A Bc Def Ghij Klmno', Str::ucwords('a bc def ghij klmno'));
        $this->assertEquals('A Bcdefghi Jklmno', Str::ucwords('a bcdefghi jklmno'));
    }

    // endregion

    // region: Style Transforms

    public function testStudly()
    {
        $this->assertEquals('a_bc_def', Str::studly("a_bc_def", []));
        $this->assertEquals('ABcDef', Str::studly("a_bc_def"));
        $this->assertEquals('AbCdEfGh', Str::studly("ab.cd_ef,gh", ['_', '.', ',']));
    }

    public function testCamel()
    {
        $this->assertEquals('a_bc_def', Str::camel("a_bc_def", []));
        $this->assertEquals('aBcDef', Str::camel("a_bc_def"));
        $this->assertEquals('abCdEfGh', Str::camel("ab.cd_ef,gh", ['_', '.', ',']));
    }

    public function testSeparated()
    {
        $this->assertEquals('abc_Def_Ghi', Str::separated("abcDefGhi"));
        $this->assertEquals('Abc-Def-Ghi', Str::separated("AbcDefGhi", '-'));
        $this->assertEquals('abc-def-ghi', Str::separated("AbcDefGhi", '-', 'lower'));
        $this->assertEquals('ABC-DEF-GHI', Str::separated("AbcDefGhi", '-', 'upper'));
        $this->assertEquals('abc-Def-Ghi', Str::separated("AbcDefGhi", '-', 'lcfirst'));
        $this->assertEquals('Abc-Def-Ghi', Str::separated("abcDefGhi", '-', 'ucfirst'));
        $this->assertEquals('Abc-def-ghi', Str::separated("AbcDefGhi", '-', 'ucwords'));
    }

    public function testSeparatedEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$separator parameter must be a non-empty string."
        );
        Str::separated('abcDefGhi', '');
    }

    // endregion

    // region: Formatting

    public function testNsprintf()
    {
        $this->assertEquals('abcdef', Str::nsprintf('a%letter$scdef', ['letter' => 'b']));
        $this->assertEquals('abcdef', Str::nsprintf('a%ltr1$scd%ltr2$sf', ['ltr1' => 'b', 'ltr2' => 'e']));
    }

    public function testNsprintfEx01()
    {
        $this->setExpectedException('\BadFunctionCallException');
        Str::nsprintf('a%ltr1$scd%ltr2$sf', ['ltr1' => 'b']);
    }

    // endregion
}
