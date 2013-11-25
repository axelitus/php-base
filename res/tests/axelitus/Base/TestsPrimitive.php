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

use axelitus\Base\Primitives\Primitive;

/**
 * Class TestsPrimitive
 *
 * @package axelitus\Base
 */
class TestsPrimitive extends TestCase
{
    /** @var Primitive $stub */
    protected $stub;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array(null);
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Primitive', $args);
    }

    /**
     * Tests is function NotImplementedException
     */
    public function test_is()
    {
        $this->setExpectedException('axelitus\Base\Exceptions\NotImplementedException');
        Primitive::is('primitive');
    }

    /**
     * Tests areEqual function NotImplementedException
     */
    public function test_areEqual()
    {
        $this->setExpectedException('axelitus\Base\Exceptions\NotImplementedException');
        Primitive::areEqual('a', 'b');
    }

    /**
     * Tests Primitive::getType()
     */
    public function test_getType()
    {
        $expected = 'object';
        $output = $this->stub->getType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Primitive::getValueType()
     */
    public function test_getValueType()
    {
        $expected = 'NULL';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Primitive::getValue()
     */
    public function test_getValue()
    {
        $expected = null;
        $output = $this->stub->getValue();
        $this->assertEquals($expected, $output);

        $expected = 'Value is null, so return this string';
        $output = $this->stub->getValue($expected);
        $this->assertEquals($expected, $output);

        $expected = 9;
        $output = $this->stub->getValue($expected);
        $this->assertEquals($expected, $output);
    }
}
