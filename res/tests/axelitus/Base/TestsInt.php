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
 * Class TestsInt
 *
 * @package axelitus\Base
 */
class TestsInt extends TestCase
{
    /**
     * Tests Int::is()
     */
    public function test_isInt()
    {
        $this->assertTrue(Int::is(0), "The value 0 is not recognized as an int.");
        $this->assertTrue(Int::is(5), "The value 5 is not recognized as an int.");
        $this->assertTrue(Int::is(-23), "The value -23 is not recognized as an int.");
        $this->assertTrue(Int::is(0.0), "The value 0.0 is not recognized as an int.");
        $this->assertTrue(Int::is(7.0), "The value 7.0 is not recognized as an int.");
        $this->assertTrue(Int::is(-23.0), "The value -23.0 is not recognized as an int.");
        $this->assertTrue(Int::is("65"), "The value \"65\" is not recognized as an int.");
        $this->assertFalse(Int::is(5.23), "The value 5.0 is incorrectly recognized as an int.");
        $this->assertFalse(Int::is(-4.9), "The value -4.9 is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("string"), "The value \"string\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("2. string"), "The value \"2. string\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("7. string 9"), "The value \"7. string 9\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is("string 4"), "The value \"string 4\" is incorrectly recognized as an int.");
        $this->assertFalse(Int::is([]), "The value [] is incorrectly recognized as an int.");
    }
}
