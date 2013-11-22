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

use axelitus\Base\Primitives\Boolean\PrimitiveBoolean;

/**
 * Class TestsPrimitiveBoolean
 *
 * @package axelitus\Base
 */
class TestsPrimitiveBoolean extends TestCase
{
    /** @var PrimitiveBoolean $stub */
    protected $stub;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array(false);
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Boolean\PrimitiveBoolean', $args);
    }

    /**
     * Tests wrong value InvalidArgumentException
     */
    public function test_wrongValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $args = array('string');
        /** @noinspection PhpUnusedLocalVariableInspection */
        $primitive = $this->getMockForAbstractClass('axelitus\Base\Primitives\Boolean\PrimitiveBoolean', $args);
    }

    /**
     * Tests Primitive::getValueType()
     */
    public function test_getValueType()
    {
        $expected = 'boolean';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests PrimitiveBoolean::native()
     */
    public function test_native()
    {
        $this->assertTrue(is_bool(PrimitiveBoolean::native($this->stub)));
    }
}
