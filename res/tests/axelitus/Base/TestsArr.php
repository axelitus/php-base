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

use axelitus\Base\Arr;

/**
 * Class TestsArr
 *
 * @package axelitus\Base
 */
class TestsArr extends TestCase
{
    /**
     * Tests Arr::is()
     */
    public function test_isArr()
    {
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $array_access = new Arr($array);

        $this->assertTrue(Arr::is($array));
        $this->assertTrue(Arr::is($array_access));
    }

    /**
     * Tests Arr::dget()
     */
    public function test_dget()
    {
        $array = ['A', 'b' => 'B', 'c' => ['cc' => 'CC'], 'D'];

        $this->assertEquals('A', Arr::dget($array, 0));
        $this->assertEquals('B', Arr::dget($array, 'b'));
        $this->assertEquals('CC', Arr::dget($array, 'c.cc'));
        $this->assertEquals('D', Arr::dget($array, 1));
        $this->assertEquals(['b' => 'B', 'c.cc' => 'CC'], Arr::dget($array, ['b', 'c.cc']));
    }

    /**
     * Tests Arr::dset()
     */
    public function test_dset()
    {
        $input = [];

        $key = 'a';
        $value = 'A';
        Arr::dset($input, $key, $value);
        $this->assertArrayHasKey($key, $input);
        $this->assertEquals('A', $input['a']);

        $key = 'b.bb.bbb';
        $value = 'BBB';
        Arr::dset($input, $key, $value);
        $this->assertArrayHasKey('b', $input);
        $this->assertArrayHasKey('bb', $input['b']);
        $this->assertArrayHasKey('bbb', $input['b']['bb']);
        $this->assertEquals('BBB', $input['b']['bb']['bbb']);

        $data = ['c' => 'C', 'd.dd' => 'DD'];
        Arr::dset($input, $data);
        $this->assertArrayHasKey('c', $input);
        $this->assertEquals('C', $input['c']);
        $this->assertArrayHasKey('d', $input);
        $this->assertArrayHasKey('dd', $input['d']);
        $this->assertEquals('DD', $input['d']['dd']);
    }

    /**
     * Tests Arr::get()
     * @depends test_dget
     */
    public function test_get()
    {
        $arr = new Arr(['A', 'b' => 'B', 'c' => ['cc' => 'CC'], 'D']);

        $this->assertEquals('A', $arr->get(0));
        $this->assertEquals('B', $arr->get('b'));
        $this->assertEquals('CC', $arr->get('c.cc'));
        $this->assertEquals('D', $arr->get(1));
        $this->assertEquals(['b' => 'B', 'c.cc' => 'CC'], $arr->get(['b', 'c.cc']));
    }

    /**
     * Tests Arr::dhas()
     */
    public function test_dhas()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => ['cc' => 'CC'], 'd'];
        $this->assertTrue(Arr::dhas($array, 0));
        $this->assertTrue(Arr::dhas($array, 'a'));
        $this->assertTrue(Arr::dhas($array, 'c.cc'));
    }

    /**
     * Tests Arr::ddelete
     */
    public function test_ddelete()
    {
        $array = ['a' => 'A', 'b' => 'B'];
        $this->assertTrue(Arr::ddelete($array, 'a'));
        $this->assertEquals(1, count($array));
        $this->assertEquals(['b' => 'B'], $array);
    }
}
