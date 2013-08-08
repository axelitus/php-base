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
     * Tests the String::isEqual() function.
     * @depends test_is_string
     */
    public function test_is_equal()
    {
        $this->assertTrue(String::isEqual("", ""), "The string \"\" is evaluated as not equal to the string \"\".");
        $this->assertTrue(String::isEqual("axelitus", "axelitus"), "The string \"axelitus\" is evaluated as not equal to the string \"axelitus\".");
        $this->assertTrue(String::isEqual("Winter is coming...", new String("Winter is coming...")), "The string \"Winter is coming...\" is evaluated as not equal to the string [String: { \$value: \"Winter is coming...\" }]].");
        $this->assertTrue(String::isEqual(new String("Objects"), new String("Objects")), "The string [String: { \$value: \"Objects\" }]] is evaluated as not equal to the string [String: { \$value: \"Objects\" }]].");
        $this->assertFalse(String::isEqual("This is", "not equal"), "The string \"This is\" is evaluated as equal to the string \"not equal\".");
        $this->assertFalse(String::isEqual("This is", new String("not equal")), "The string \"This is\" is evaluated as equal to the string [String: { \$value: \"not equal\" }]].");
    }

    /**
     * Tests the String::length() function.
     * @depends test_is_string
     */
    public function test_length()
    {
        $this->assertEquals(0, String::length(""));
        $this->assertEquals(33, String::length("This is a 33 chars length string."), "The length is not correctly calculated.");
        $this->assertEquals(83, String::length("This string, however, is a little bit longer, having in total a length of 83 chars."), "The length is not correctly calculated.");
    }

    /**
     * Tests the String::sub() function.
     * @depends test_is_string
     */
    public function test_sub()
    {
        $this->assertEquals("", String::sub("", 0, 2), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("is coming...", String::sub("Winter is coming...", 7), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("coming", String::sub("Winter is coming...", 10, 6), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("Winter", String::sub("Winter is coming...", 0, 6), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("...", String::sub("Winter is coming...", -3), "The resulting substring is not equal to the expected string \"is coming...\".");
    }

    /**
     * Tests the String::beginsWith() function.
     * @depends test_is_string
     */
    public function test_begins_with()
    {
        $this->assertTrue(String::beginsWith("Winter is coming...", "Winter"), "The string \"Winter is coming...\" does not begin with the string \"Winter\".");
        $this->assertTrue(String::beginsWith("Winter is coming...", "winter", false), "The string \"Winter is coming...\" does not begin with the string \"winter\" [case insensitive].");
        $this->assertFalse(String::beginsWith("Winter is coming...", "winter", true), "The string \"Winter is coming...\" does not begin with the string \"winter\" [case sensitive].");
    }

    /**
     * Tests the String::endsWith() function.
     * @depends test_is_string
     */
    public function test_ends_with()
    {
        $this->assertTrue(String::endsWith("It is known, Khaleesi.", "Khaleesi."), "The string \"It is known, Khaleesi.\" does not end with the string \"Khaleesi..\".");
        $this->assertTrue(String::endsWith("It is known, Khaleesi.", "khaleesi.", false), "The string \"It is known, Khaleesi.\" does not end with the string \"khaleesi.\" [case insensitive].");
        $this->assertFalse(String::endsWith("It is known, Khaleesi.", "khaleesi.", true), "The string \"It is known, Khaleesi.\" does not end with the string \"khaleesi.\" [case sensitive].");
        $this->assertFalse(String::endsWith("It is known, Khaleesi.", "Khaleesi"), "The string \"It is known, Khaleesi.\" does not end with the string \"Khaleesi\"..");
    }
}
