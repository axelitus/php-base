<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Arr;

/**
 * Class TestsArr
 *
 * @package axelitus\Base
 */
class TestsArr extends TestCase
{
    // region: Properties

    /** @var \axelitus\Base\Arr */
    private $arr;

    // endregion

    // region: SetUp

    public function setUp()
    {
        $this->arr = new Arr();
    }

    // endregion

    // region: Constructors

    public function testNew()
    {
        $data = static::getNonPublicPropertyValue($this->arr, 'data');
        $this->assertInternalType('array', $data);
        $this->assertEquals([], $data);

        $a = ['first' => 'value', 'second' => ['lvl' => 'lvl value']];
        $this->arr = new Arr($a);
        $data = static::getNonPublicPropertyValue($this->arr, 'data');
        $this->assertInternalType('array', $data);
        $this->assertEquals($a, $data);
    }

    // endregion

    // region: Get & Set

    public function testGet()
    {
        static::getNonPublicProperty($this->arr, 'data')->setValue(
            $this->arr,
            ['first' => 'value', 'second' => ['lvl' => ['opt' => 'other value']]]
        );

        $this->assertEquals('value', $this->arr->get('first'));
        $this->assertEquals('other value', $this->arr->get('second.lvl.opt'));
        $this->assertEquals(null, $this->arr->get('third'));
    }

    public function testSet()
    {
        $this->arr->set('first', 'value');
        $this->arr->set('second.lvl.opt', 'other value');

        $data = static::getNonPublicPropertyValue($this->arr, 'data');
        $this->assertArrayHasKey('first', $data);
        $this->assertEquals('value', $data['first']);
        $this->assertArrayHasKey('second', $data);
        $this->assertArrayHasKey('lvl', $data['second']);
        $this->assertArrayHasKey('opt', $data['second']['lvl']);
        $this->assertEquals('other value', $data['second']['lvl']['opt']);
    }

    public function testDelete()
    {
        static::getNonPublicProperty($this->arr, 'data')->setValue(
            $this->arr,
            ['first' => 'value', 'second' => ['lvl' => ['opt' => 'other value']], 'third' => ['sub' => 'sub value']]
        );

        $this->assertTrue($this->arr->delete('first'));
        $data = static::getNonPublicPropertyValue($this->arr, 'data');
        $this->assertArrayNotHasKey('first', $data);

        $this->assertFalse($this->arr->delete('fourth'));

        $this->assertEquals(
            ['second' => true, 'third' => true, 'fifth' => false],
            $this->arr->delete(['second', 'third', 'fifth'])
        );
        $data = static::getNonPublicPropertyValue($this->arr, 'data');
        $this->assertArrayNotHasKey('second', $data);
        $this->assertArrayNotHasKey('third', $data);
        $this->assertEquals([], $data);
    }

    // endregion

    // region: Matches

    public function testHas()
    {
        static::getNonPublicProperty($this->arr, 'data')->setValue(
            $this->arr,
            ['first' => 'value', 'second' => ['lvl' => ['opt' => 'other value']], 'third' => ['sub' => 'sub value']]
        );

        $this->assertTrue($this->arr->has('first'));
        $this->assertTrue($this->arr->has('second.lvl'));
        $this->assertFalse($this->arr->has('fourth'));
        $this->assertEquals(
            ['first' => true, 'third.sub' => true, 'fifth' => false],
            $this->arr->has(['first', 'third.sub', 'fifth'])
        );
    }

    // endregion

    // region: Conversion

    public function testAsArray()
    {
        $a = ['one' => 'A', 'two' => 'B', 'three' => ['one' => 'C.A', 'two' => 'C.B']];
        $this->arr = new Arr($a);
        $this->assertEquals($a, $this->arr->asArray());
    }

    // endregion

    // region: Implements \ArrayAccess

    /**
     * @depends testGet
     * @depends testSet
     * @depends testDelete
     * @depends testHas
     */
    public function testArrayAccess()
    {
        // test offsetGet and offsetSet
        $this->assertEquals(null, $this->arr['first.sub.val']);
        $this->arr['first.sub.val'] = 'value';
        $this->assertEquals('value', $this->arr['first.sub.val']);

        // test offsetExists and offsetUnset
        $this->assertTrue(isset($this->arr['first.sub.val']));
        unset($this->arr['first.sub.val']);
        $this->assertFalse(isset($this->arr['first.sub.val']));
    }

    // endregion

    // region: Implements \Countable

    public function testCountable()
    {
        $this->assertEquals(0, count($this->arr));
        $this->assertEquals(-1, $this->arr->count('first'));

        static::getNonPublicProperty($this->arr, 'data')->setValue(
            $this->arr,
            [
                'first'  => 'value',
                'second' => ['lvl' => ['opt' => ['value 1', 'value 2', 'value 3', 'value 4', 'value 5']]],
                'third'  => ['sub' => 'sub value']
            ]
        );
        $this->assertEquals(1, $this->arr->count('first'));
        $this->assertEquals(1, $this->arr->count('second.lvl'));
        $this->assertEquals(5, $this->arr->count('second.lvl.opt'));

        $this->assertEquals(7,
            $this->arr->count(['first', 'second.lvl.opt', 'third', 'non-existent'])
        );
    }

    public function testCountableEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$key parameter must be int or string (or array of them)."
        );
        $this->arr->count(false);
    }

    // endregion

    // region: Implements \Iterator

    public function testForEachLoop()
    {
        $this->arr['a.aa.aaa'] = 'A.AA.AAA';
        $this->arr['b.bb.bbb'] = 'B.BB.BBB';
        $this->arr['c.cc1'] = 'C.CC1';
        $this->arr['c.cc2'] = 'C.CC2';
        $this->arr['d'] = 'D';

        foreach ($this->arr as $key => $value) {
            switch($key){
                case 'a':
                    $this->assertEquals(['aa' => ['aaa' => 'A.AA.AAA']], $value);
                    break;
                case 'b':
                    $this->assertEquals(['bb' => ['bbb' => 'B.BB.BBB']], $value);
                    break;
                case 'c':
                    $this->assertEquals(['cc1' => 'C.CC1', 'cc2' => 'C.CC2'], $value);
                    break;
                case 'd':
                    $this->assertEquals('D', $value);
                    break;
            }
        }
    }

    // endregion
}
