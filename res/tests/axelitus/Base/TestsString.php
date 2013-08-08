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

class TestsString extends TestCase
{
    /**
     * Tests the String::is() function.
     */
    public function test_is_string()
    {
        $this->assertFalse(String::is(null), "The value null is incorrectly recognized as a string.");
        $this->assertTrue(String::is(""), "The value \"\" is not recognized as a string.");
        $this->assertTrue(String::is("Winter is coming!"), "The value \"Winter is coming!\" is not recognized as a string.");
        $this->assertTrue(String::is(new String("It is known.")), "The value [String:{ \$value: string(\"It is known.\") }] is not recognized as a string.");
        $this->assertFalse(String::is(56), "The value 56 is incorrectly recognized as a string.");
        $this->assertFalse(String::is(10.3), "The value 10.3 is incorrectly recognized as a string.");
    }

    /**
     * Tests the String::length() function.
     */
    public function test_length()
    {
        $this->assertEquals(33, String::length("This is a 33 chars length string."), "The length is not correctly calculated.");
        $this->assertEquals(83, String::length("This string, however, is a little bit longer, having in total a length of 83 chars."), "The length is not correctly calculated.");
    }

    // TODO: test the rest of the String functions
}
