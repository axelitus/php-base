<?php
/**
 * axelitus/base - Primitive extensions and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.4
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Primitives\String\PrimitiveString;

/**
 * Class TestsPrimitiveString
 *
 * @package axelitus\Base
 */
class TestsPrimitiveString extends TestCase
{
    /** @var PrimitiveString $stub */
    protected $stub;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array('string');
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\String\PrimitiveString', $args);
    }

    /**
     * Tests wrong value InvalidArgumentException
     */
    public function test_wrongValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $args = array(58);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $primitive = $this->getMockForAbstractClass('axelitus\Base\Primitives\String\PrimitiveString', $args);
    }

    /**
     * Tests Primitive::getValueType()
     */
    public function test_getValueType()
    {
        $expected = 'string';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests PrimitiveString::native()
     */
    public function test_native()
    {
        $this->assertTrue(is_string(PrimitiveString::native($this->stub)));
    }
}
