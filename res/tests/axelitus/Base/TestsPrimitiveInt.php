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

namespace axelitus\Base;

/**
 * Class TestsPrimitiveInt
 *
 * @package axelitus\Base
 */
class TestsPrimitiveInt extends TestCase
{
    protected $stub;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array(9);
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\Types\PrimitiveInt', $args);
    }

    /**
     * Tests wrong value InvalidArgumentException
     */
    public function test_wrongValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $args = array('string');
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\Types\PrimitiveInt', $args);
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
        $expected = 'integer';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }
}
