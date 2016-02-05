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

use axelitus\Base\DotArr;

/**
 * Class TestsDotArr
 *
 * @package axelitus\Base
 */
class TestsDotArr extends TestCase
{
    // region: Value Testing

    public function testIs()
    {
        $this->assertTrue(DotArr::is([]));
        $this->assertTrue(DotArr::is(['a', 'b', 'c']));
        $this->assertTrue(DotArr::is([0 => 'a', 1 => 'b', 2 => 'c']));
        $this->assertTrue(DotArr::is([2 => 'a', 0 => 'b', 1 => 'c']));
        $this->assertTrue(DotArr::is(['first' => 'a', 'second' => 'b', 'third' => 'c']));
        $this->assertFalse(DotArr::is(['first.dot' => 'a', 'second' => 'b', 'third' => 'c']));
        $this->assertFalse(DotArr::is(['first' => 'a', 'second.dot' => 'b', 'third' => 'c']));
        $this->assertFalse(DotArr::is(['first' => 'a', 'second' => 'b', 'third.dot' => 'c']));

        $this->assertTrue(DotArr::is(['a', 'b', 'c', ['d', 'e']]));
        $this->assertTrue(DotArr::is([0 => 'a', 1 => 'b', 2 => 'c', 3 => [0 => 'd', 1 => 'e']]));
        $this->assertTrue(DotArr::is([2 => 'a', 0 => 'b', 1 => 'c', 3 => [1 => 'd', 0 => 'e']]));
        $this->assertTrue(
            DotArr::is(['first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => ['first' => 'd', 'second' => 'e']])
        );
        $this->assertFalse(
            DotArr::is(
                ['first.dot' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => ['first' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second.dot' => 'b', 'third' => 'c', 'fourth' => ['first' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second' => 'b', 'third.dot' => 'c', 'fourth' => ['first' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second' => 'b', 'third.dot' => 'c', 'fourth' => ['first' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth.dot' => ['first' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => ['first.dot' => 'd', 'second' => 'e']]
            )
        );
        $this->assertFalse(
            DotArr::is(
                ['first' => 'a', 'second' => 'b', 'third' => 'c', 'fourth' => ['first' => 'd', 'second.dot' => 'e']]
            )
        );
    }

    // endregion

    // region: Get & Set

    public function testGet()
    {
        $this->assertEquals(null, DotArr::get(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'd'));
        $this->assertEquals(true, DotArr::get(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'd', true));
        $this->assertEquals('A', DotArr::get(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'a'));
        $this->assertEquals('A.AA', DotArr::get(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], 'a.aa'));
        $this->assertEquals(
            ['aaa' => 'A.AA.AAA'],
            DotArr::get(['a' => ['aa' => ['aaa' => 'A.AA.AAA']], 'b' => 'B', 'c' => 'C'], 'a.aa')
        );
        $this->assertEquals(
            'A.AA.AAA',
            DotArr::get(['a' => ['aa' => ['aaa' => 'A.AA.AAA']], 'b' => 'B', 'c' => 'C'], 'a.aa.aaa')
        );

        $this->assertEquals(
            ['a.aa' => 'A.AA', 'b' => 'B'],
            DotArr::get(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'b'])
        );
        $this->assertEquals(
            ['a.aa' => 'A.AA', 'd' => null],
            DotArr::get(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'd'])
        );
        $this->assertEquals(
            ['a.aa' => 'A.AA', 'a.aaa' => null],
            DotArr::get(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'a.aaa'])
        );
    }

    public function testGetEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or an array of them)."
        );
        DotArr::get([], true);
    }

    public function testSet()
    {
        $array = [];

        DotArr::set($array, 'key', 'value');
        $this->assertArrayHasKey('key', $array);

        DotArr::set($array, 'first.sub', 'dot value');
        $this->assertArrayHasKey('first', $array);
        $this->assertInternalType('array', $array['first']);
        $this->assertArrayHasKey('sub', $array['first']);

        DotArr::set($array, ['second' => 'multiple keys', 'third.sub' => 'multiple keys']);
        $this->assertArrayHasKey('second', $array);
        $this->assertArrayHasKey('third', $array);
        $this->assertInternalType('array', $array['third']);
        $this->assertArrayHasKey('sub', $array['third']);
    }

    public function testSetEx01()
    {
        $array = [];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or an array of them)."
        );
        DotArr::set($array, true);
    }

    public function testDelete()
    {
        $array = [
            'first'  => 'value',
            'second' => ['lvl' => ['opt' => 'other value']],
            'third'  => ['sub' => ['k' => 'v']]
        ];

        $this->assertTrue(DotArr::delete($array, 'first'));
        $this->assertArrayNotHasKey('first', $array);

        $this->assertTrue(DotArr::delete($array, 'second.lvl.opt'));
        $this->assertArrayHasKey('second', $array);
        $this->assertArrayHasKey('lvl', $array['second']);
        $this->assertInternalType('array', $array['second']['lvl']);
        $this->assertArrayNotHasKey('opt', $array['second']['lvl']);

        $this->assertFalse(DotArr::delete($array, 'third.sub.k.v'));
        $this->assertTrue(DotArr::delete($array, 'third.sub'));
        $this->assertArrayHasKey('third', $array);
        $this->assertInternalType('array', $array['third']);
        $this->assertArrayNotHasKey('sub', $array['third']);

        $this->assertFalse(DotArr::delete($array, 'fourth'));

        $this->assertEquals(
            ['second' => true, 'third' => true, 'fifth' => false],
            DotArr::delete($array, ['second', 'third', 'fifth'])
        );
    }

    public function testDeleteEx01()
    {
        $array = [];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or an array of them)."
        );
        DotArr::delete($array, true);
    }

    // endregion

    // region: Matches

    public function testKeyExists()
    {
        $this->assertFalse(DotArr::keyExists(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'd'));
        $this->assertTrue(DotArr::keyExists(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'a'));
        $this->assertTrue(DotArr::keyExists(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], 'a.aa'));
        $this->assertTrue(DotArr::keyExists(['a' => ['aa' => ['aaa' => 'A.AA.AAA']], 'b' => 'B', 'c' => 'C'], 'a.aa'));
        $this->assertTrue(
            DotArr::keyExists(['a' => ['aa' => ['aaa' => 'A.AA.AAA']], 'b' => 'B', 'c' => 'C'], 'a.aa.aaa')
        );

        $this->assertEquals(
            ['a.aa' => true, 'b' => true],
            DotArr::keyExists(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'b'])
        );
        $this->assertEquals(
            ['a.aa' => true, 'd' => false],
            DotArr::keyExists(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'd'])
        );
        $this->assertEquals(
            ['a.aa' => true, 'a.aaa' => false],
            DotArr::keyExists(['a' => ['aa' => 'A.AA'], 'b' => 'B', 'c' => 'C'], ['a.aa', 'a.aaa'])
        );
    }

    public function testKEyExistsEx01()
    {
        $array = [];
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or an array of them)."
        );
        DotArr::keyExists($array, true);
    }

    public function testKeyMatches()
    {
        $array = ['first' => ['second' => ['third' => ['fourth' => ['fifth' => 'value']]]]];
        $this->assertEquals([], DotArr::keyMatches($array, 'none'));
        $this->assertEquals(['first'], DotArr::keyMatches($array, 'first'));
        $this->assertEquals(['first', 'first.second'], DotArr::keyMatches($array, 'first.second'));
        $this->assertEquals(
            ['first', 'first.second', 'first.second.third'],
            DotArr::keyMatches($array, 'first.second.third')
        );
        $this->assertEquals(
            ['first', 'first.second', 'first.second.third', 'first.second.third.fourth'],
            DotArr::keyMatches($array, 'first.second.third.fourth')
        );
        $this->assertEquals(
            [
                'first',
                'first.second',
                'first.second.third',
                'first.second.third.fourth',
                'first.second.third.fourth.fifth'
            ],
            DotArr::keyMatches($array, 'first.second.third.fourth.fifth')
        );
        $this->assertEquals(
            [
                'first',
                'first.second',
                'first.second.third',
                'first.second.third.fourth',
                'first.second.third.fourth.fifth'
            ],
            DotArr::keyMatches($array, 'first.second.third.fourth.fifth.sixth')
        );

        $array = ['first' => ['sub' => ['arr' => 'value']], 'second' => ['lvl' => ['opt' => 'value']]];
        $this->assertEquals(
            [
                'first.sub.arr'  => ['first', 'first.sub', 'first.sub.arr'],
                'second.lvl.opt' => ['second', 'second.lvl', 'second.lvl.opt']
            ],
            DotArr::keyMatches($array, ['first.sub.arr', 'second.lvl.opt'])
        );
    }

    public function testKeyMAtchesEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or an array of them)."
        );
        DotArr::keyMatches(['first'], true);
    }

    // endregion

    // region: Convert

    public function testConvert()
    {
        $this->assertEquals([], DotArr::convert([]));
        $this->assertEquals(['first'], DotArr::convert(['first']));
        $this->assertEquals(
            ['first' => ['sub' => 'value'], 'second' => 'value'],
            DotArr::convert(['first' => ['sub' => 'value'], 'second' => 'value'])
        );
        $this->assertEquals(
            ['first' => ['sub' => 'value'], 'second' => 'value'],
            DotArr::convert(['first.sub' => 'value', 'second' => 'value'])
        );
        $this->assertEquals(
            ['first' => ['second' => ['third' => 'value', 'fourth' => 'value']]],
            DotArr::convert(['first.second.third' => 'value', 'first.second.fourth' => 'value'])
        );
        $this->assertEquals(
            ['first' => ['second' => ['third' => 'value']]],
            DotArr::convert(['first.second' => 'value', 'first.second.third' => 'value'])
        );
        $this->assertEquals(
            ['first' => ['second' => 'value']],
            DotArr::convert(['first.second.third' => 'value', 'first.second' => 'value'])
        );
        $this->assertEquals(
            ['first' => ['second' => ['third' => ['fourth' => 'value']]]],
            DotArr::convert(['first.second' => ['third.fourth' => 'value']])
        );
    }

    // endregion
}
