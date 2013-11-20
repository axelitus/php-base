<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.2
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base\Tests;

/**
 * Class TestsPrimitiveFloat
 *
 * @package axelitus\Base
 */
class TestsPrimitiveFloat extends TestCase
{
    protected $stub;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array(9.5);
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\Types\PrimitiveFloat', $args);
    }

    /**
     * Tests wrong value InvalidArgumentException
     */
    public function test_wrongValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $args = array('string');
        /** @noinspection PhpUnusedLocalVariableInspection */
        $primitive = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\Types\PrimitiveFloat', $args);
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
        $expected = 'double';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }
}
