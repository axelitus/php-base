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

use axelitus\Base\Primitives\Numeric\Types\PrimitiveInt;

/**
 * Class TestsPrimitiveInt
 *
 * @package axelitus\Base
 */
class TestsPrimitiveInt extends TestCase
{
    /** @var PrimitiveInt $stub */
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
        /** @noinspection PhpUnusedLocalVariableInspection */
        $primitive = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\Types\PrimitiveInt', $args);
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

    /**
     * Tests PrimitiveInt::native()
     */
    public function test_native()
    {
        $this->assertTrue(is_int(PrimitiveInt::native($this->stub)));
    }
}
