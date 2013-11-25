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

use axelitus\Base\Primitives\Numeric\Types\PrimitiveFloat;

/**
 * Class TestsPrimitiveFloat
 *
 * @package axelitus\Base
 */
class TestsPrimitiveFloat extends TestCase
{
    /** @var PrimitiveFloat $stub */
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
     * Tests Primitive::getValueType()
     */
    public function test_getValueType()
    {
        $expected = 'double';
        $output = $this->stub->getValueType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests PrimitiveFloat::native()
     */
    public function test_native()
    {
        $this->assertTrue(is_float(PrimitiveFloat::native($this->stub)));
    }
}
