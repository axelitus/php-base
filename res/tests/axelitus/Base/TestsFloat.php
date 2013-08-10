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
 * Class TestsFloat
 *
 * @package axelitus\Base
 */
class TestsFloat extends TestCase
{
    /**
     * Tests Float::is()
     */
    public function test_is_float()
    {
        $this->assertTrue(Float::is(0), "The value 0 is not recognized as a float.");
        $this->assertTrue(Float::is(5), "The value 5 is not recognized as a float.");
        $this->assertTrue(Float::is(-23), "The value -23 is not recognized as a float.");
        $this->assertTrue(Float::is(0.0), "The value 0.0 is not recognized as a float.");
        $this->assertTrue(Float::is(5.23), "The value 5.23 is not recognized as a float.");
        $this->assertTrue(Float::is(-4.9), "The value -4.9 is not recognized as a float.");
        $this->assertTrue(Float::is("7.3"), "The value 7.3 is not recognized as a float.");
        $this->assertTrue(Float::is("-3.984"), "The value -3.984 is not recognized as a float.");
        $this->assertFalse(Float::is("string"), "The value \"string\" is incorrectly recognized as a float.");
        $this->assertFalse(Float::is("2. string"), "The value \"2. string\" is incorrectly recognized as a float.");
        $this->assertFalse(Float::is("7. string 9"), "The value \"7. string 9\" is incorrectly recognized as a float.");
        $this->assertFalse(Float::is("string 4"), "The value \"string 4\" is incorrectly recognized as a float.");
        $this->assertFalse(Float::is([]), "The value [] is incorrectly recognized as an int.");
    }
}
