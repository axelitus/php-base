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

use axelitus\Base\Primitives\Numeric\PrimitiveNumeric;

/**
 * Class TestsPrimitiveNumeric
 *
 * @package axelitus\Base
 */
class TestsPrimitiveNumeric extends TestCase
{
    /** @var PrimitiveNumeric $stubInt */
    protected $stubInt;

    /** @var PrimitiveNumeric $stubFloat */
    protected $stubFloat;

    /**
     * Setup function
     */
    public function setUp()
    {
        $args = array(9);
        $this->stubInt = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\PrimitiveNumeric', $args);

        $args = array(9.5);
        $this->stubFloat = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\PrimitiveNumeric', $args);
    }

    /**
     * Tests wrong value InvalidArgumentException
     */
    public function test_wrongValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $args = array('string');
        /** @noinspection PhpUnusedLocalVariableInspection */
        $primitive = $this->getMockForAbstractClass('axelitus\Base\Primitives\Numeric\PrimitiveNumeric', $args);
    }

    /**
     * Tests Primitive::getValueType()
     */
    public function test_getValueType()
    {
        $expected = 'integer';
        $output = $this->stubInt->getValueType();
        $this->assertEquals($expected, $output);

        $expected = 'double';
        $output = $this->stubFloat->getValueType();
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests PrimitiveNumeric::native()
     */
    public function test_native()
    {
        $this->assertTrue(is_numeric(PrimitiveNumeric::native($this->stubInt)));
        $this->assertTrue(is_numeric(PrimitiveNumeric::native($this->stubFloat)));
    }
}
