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

use axelitus\Base\Primitives\Primitive;

/**
 * Class TestsPrimitive
 *
 * @package axelitus\Base
 */
class TestsPrimitive extends TestCase
{
    protected $stub;

    public function setUp()
    {/*
        $args = array(null);
        $this->stub = $this->getMockForAbstractClass('axelitus\Base\Primitives\Primitive', $args);
*/
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
}
