<?php
/**
 * Part of composer package: axelitus/base
 *
 * @package     axelitus\Base
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 */

namespace axelitus\Base;

/**
 * Class TestsBoolean
 *
 * @package axelitus\Base
 */
class TestsBoolean extends TestCase
{
    /**
     * Tests Boolean::is()
     */
    public function test_is_bool()
    {
        $this->assertTrue(Boolean::is(true), "The value true is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(false), "The value false is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(1), "The value 1 is not recognized as a boolean.");
        $this->assertTrue(Boolean::is(0), "The value 0 is not recognized as a boolean.");
        $this->assertFalse(Boolean::is("true"), "The value \"true\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("false"), "The value \"false\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("1"), "The value \"1\" is incorrectly recognized as a boolean.");
        $this->assertFalse(Boolean::is("0"), "The value \"0\" is incorrectly recognized as a boolean.");
    }
}
