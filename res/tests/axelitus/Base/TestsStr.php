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

use axelitus\Base\Str;

/**
 * Class TestsString
 *
 * @package axelitus\Base
 */
class TestsString extends TestCase
{
    /**
     * Tests the String::is() function.
     */
    public function test_isString()
    {
        $this->assertFalse(Str::is(null), "The value null is incorrectly recognized as a string.");
        $this->assertTrue(Str::is(""), "The value \"\" is not recognized as a string.");
        $this->assertTrue(Str::is("Winter is coming!"), "The value \"Winter is coming!\" is not recognized as a string.");
        $this->assertTrue(Str::is(new Str("It is known.")), "The value [String:{ \$value: string(\"It is known.\") }] is not recognized as a string.");
        $this->assertFalse(Str::is(56), "The value 56 is incorrectly recognized as a string.");
        $this->assertFalse(Str::is(10.3), "The value 10.3 is incorrectly recognized as a string.");
    }

    /**
     * Tests the String::areEqual() function.
     * @depends test_isString
     */
    public function test_areEqual()
    {
        $this->assertTrue(Str::areEqual("", ""), "The string \"\" is evaluated as not equal to the string \"\".");
        $this->assertTrue(Str::areEqual("axelitus", "axelitus"), "The string \"axelitus\" is evaluated as not equal to the string \"axelitus\".");
        $this->assertTrue(Str::areEqual("Winter is coming...", new Str("Winter is coming...")), "The string \"Winter is coming...\" is evaluated as not equal to the string [String: { \$value: \"Winter is coming...\" }]].");
        $this->assertTrue(Str::areEqual(new Str("Objects"), new Str("Objects")), "The string [String: { \$value: \"Objects\" }]] is evaluated as not equal to the string [String: { \$value: \"Objects\" }]].");
        $this->assertFalse(Str::areEqual("This is", "not equal"), "The string \"This is\" is evaluated as equal to the string \"not equal\".");
        $this->assertFalse(Str::areEqual("This is", new Str("not equal")), "The string \"This is\" is evaluated as equal to the string [String: { \$value: \"not equal\" }]].");
    }

    public function test_areEqualException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::areEqual('string', 0);
    }

    /**
     * Tests the String::length() function.
     * @depends test_isString
     */
    public function test_length()
    {
        $this->assertEquals(0, Str::length(""));
        $this->assertEquals(33, Str::length("This is a 33 chars length string."), "The length is not correctly calculated.");
        $this->assertEquals(83, Str::length("This string, however, is a little bit longer, having in total a length of 83 chars."), "The length is not correctly calculated.");
    }

    public function test_lengthException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::length(false);
    }

    /**
     * Tests the String::sub() function.
     * @depends test_isString
     */
    public function test_sub()
    {
        $this->assertEquals("", Str::sub("", 0, 2), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("is coming...", Str::sub("Winter is coming...", 7), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("coming", Str::sub("Winter is coming...", 10, 6), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("Winter", Str::sub("Winter is coming...", 0, 6), "The resulting substring is not equal to the expected string \"is coming...\".");
        $this->assertEquals("...", Str::sub("Winter is coming...", -3), "The resulting substring is not equal to the expected string \"is coming...\".");
    }

    public function test_subException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::sub(false, 0);
    }

    /**
     * Tests the String::pos() function.
     * @depends test_isString
     */
    public function test_pos()
    {
        $expected = 13;
        $output = Str::pos("It is known, Khaleesi.", "Khal");
        $this->assertEquals($expected, $output, "The string \"Khal\" is not found at position 13 in the string \"It is known, Khaleesi.\".");
    }

    public function test_posException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::pos(false, 'string');
    }

    public function test_posException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::pos('string', false);
    }

    /**
     * Tests the String::contains() function.
     * @depends test_isString
     * @depends test_pos
     */
    public function test_contains()
    {
        $this->assertTrue(Str::contains("It is known, Khaleesi.", "Khal"), "The string \"It is known, Khaleesi.\" does not contain the string \"Khal\".");
        $this->assertFalse(Str::contains("It is known, Khaleesi.", "khal"), "The string \"It is known, Khaleesi.\" does not contain the string \"khal\".");
        $this->assertTrue(Str::contains("It is known, Khaleesi.", "khal", false), "The string \"It is known, Khaleesi.\" does not contain the string \"khal\" (case-insensitive).");
        $this->assertFalse(Str::contains("It is known, Khaleesi.", "Chal"), "The string \"It is known, Khaleesi.\" does not contain the string \"Chal\".");
        $this->assertFalse(Str::contains("It is known, Khaleesi.", "Chal", false), "The string \"It is known, Khaleesi.\" does not contain the string \"Chal\".");
    }

    public function test_containsException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::contains(false, 'string');
    }

    public function test_containsException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::contains('string', false);
    }

    /**
     * Tests the String::beginsWith() function.
     * @depends test_isString
     * @depends test_length
     * @depends test_sub
     */
    public function test_beginsWith()
    {
        $this->assertTrue(Str::beginsWith("Winter is coming...", "Winter"), "The string \"Winter is coming...\" does not begin with the string \"Winter\".");
        $this->assertTrue(Str::beginsWith("Winter is coming...", "winter", false), "The string \"Winter is coming...\" does not begin with the string \"winter\" [case insensitive].");
        $this->assertFalse(Str::beginsWith("Winter is coming...", "winter", true), "The string \"Winter is coming...\" does not begin with the string \"winter\" [case sensitive].");
    }

    public function test_beginsWithException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::beginsWith(false, 'string');
    }

    public function test_beginsWithException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::beginsWith('string', false);
    }

    /**
     * Tests the String::endsWith() function.
     * @depends test_isString
     * @depends test_length
     * @depends test_sub
     */
    public function test_endsWith()
    {
        $this->assertTrue(Str::endsWith("It is known, Khaleesi.", "Khaleesi."), "The string \"It is known, Khaleesi.\" does not end with the string \"Khaleesi.\".");
        $this->assertTrue(Str::endsWith("It is known, Khaleesi.", "khaleesi.", false), "The string \"It is known, Khaleesi.\" does not end with the string \"khaleesi.\" [case insensitive].");
        $this->assertFalse(Str::endsWith("It is known, Khaleesi.", "khaleesi.", true), "The string \"It is known, Khaleesi.\" does not end with the string \"khaleesi.\" [case sensitive].");
        $this->assertFalse(Str::endsWith("It is known, Khaleesi.", "Khaleesi"), "The string \"It is known, Khaleesi.\" does not end with the string \"Khaleesi\".");
        $this->assertTrue(Str::endsWith("It is known, Khaleesi.", ""), "The string \"It is known, Khaleesi.\" does not end with the string \"\".");
    }

    public function test_endsWithException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::endsWith(false, 'string');
    }

    public function test_endsWithException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::endsWith('string', false);
    }

    /**
     * Tests the String::replace() function.
     * @depends test_isString
     */
    public function test_replace()
    {
        $expected = "Summer is coming...";
        $output = Str::replace("Winter is coming...", "Winter", "Summer");
        $this->assertEquals($expected, $output);

        $expected = "Winter is coming...";
        $output = Str::replace("Winter is coming...", "Autumn", "Summer");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::lower() function.
     * @depends test_isString
     */
    public function test_lower()
    {
        $expected = "winter is coming...";
        $output = Str::lower("Winter Is COMING...");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::upper() function.
     * @depends test_isString
     */
    public function test_upper()
    {
        $expected = "WINTER IS COMING...";
        $output = Str::upper("Winter Is COMING...");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::lcfirst() function.
     * @depends test_isString
     */
    public function test_lcfirst()
    {
        $expected = "winter Is COMING...";
        $output = Str::lcfirst("Winter Is COMING...");
        $this->assertEquals($expected, $output);

        $expected = "wINTER IS COMING...";
        $output = Str::lcfirst("WINTER IS COMING...");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::ucfirst() function.
     * @depends test_isString
     */
    public function test_ucfirst()
    {
        $expected = "Winter Is COMING...";
        $output = Str::ucfirst("winter Is COMING...");
        $this->assertEquals($expected, $output);

        $expected = "Winter is coming...";
        $output = Str::ucfirst("winter is coming...");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::ucwords() function.
     * @depends test_isString
     */
    public function test_ucwords()
    {
        $expected = "Winter Is Coming...";
        $output = Str::ucwords("winter is coming...");
        $this->assertEquals($expected, $output);

        $expected = "Winter Is Coming...";
        $output = Str::ucwords("WINTER IS COMING...");
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::isOneOf() function.
     * @depends test_isString
     */
    public function test_isOneOf()
    {
        $values = array('apple', 'banana', 'grapes', 'oranges');
        $this->assertTrue(Str::isOneOf('apple', $values));
        $this->assertFalse(Str::isOneOf('Apple', $values));
        $this->assertTrue(Str::isOneOf('Apple', $values, false));
    }

    public function test_isOneOfException01()
    {
        $values = array('apple', 'banana', 'grapes', 'oranges');
        $this->setExpectedException('\InvalidArgumentException');
        Str::isOneOf(false, $values);
    }

    public function test_isOneOfException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::isOneOf('string', array('value', false));
    }

    /**
     * Tests the String::studly() function.
     * @depends test_isString
     */
    public function test_studly()
    {
        $expected = "winter_is_coming";
        $output = Str::studly("winter_is_coming", array());
        $this->assertEquals($expected, $output);

        $expected = "WinterIsComing";
        $output = Str::studly("winter_is_coming");
        $this->assertEquals($expected, $output);
    }

    public function test_studlyException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::studly(false);
    }

    public function test_studlyException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::studly('separated_string', array(false));
    }

    /**
     * Tests the String::camel() function.
     * @depends test_isString
     * @depends test_studly
     */
    public function test_camel()
    {
        $expected = "winter_is_coming";
        $output = Str::camel("winter_is_coming", array());
        $this->assertEquals($expected, $output);

        $expected = "winterIsComing";
        $output = Str::camel("winter_is_coming");
        $this->assertEquals($expected, $output);
    }

    public function test_camelException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::camel(false);
    }

    public function test_camelException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::camel('separated_string', array(false));
    }

    /**
     * Tests the String::separated() function.
     * @depends test_isString
     * @depends test_isOneOf
     * @depends test_lcfirst
     * @depends test_ucfirst
     * @depends test_lower
     */
    public function test_separated()
    {
        $expected = "winter_Is_Coming";
        $output = Str::separated("winterIsComing");
        $this->assertEquals($expected, $output);

        $expected = "Winter-Is-Coming";
        $output = Str::separated("WinterIsComing", '-');
        $this->assertEquals($expected, $output);

        $expected = "winter-is-coming";
        $output = Str::separated("WinterIsComing", '-', 'lower');
        $this->assertEquals($expected, $output);

        $expected = "WINTER-IS-COMING";
        $output = Str::separated("WinterIsComing", '-', 'upper');
        $this->assertEquals($expected, $output);

        $expected = "winter-Is-Coming";
        $output = Str::separated("WinterIsComing", '-', 'lcfirst');
        $this->assertEquals($expected, $output);

        $expected = "Winter-Is-Coming";
        $output = Str::separated("winterIsComing", '-', 'ucfirst');
        $this->assertEquals($expected, $output);

        $expected = "Winter-is-coming";
        $output = Str::separated("winterIsComing", '-', 'ucwords');
        $this->assertEquals($expected, $output);
    }

    public function test_separatedException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::separated(false);
    }

    public function test_separatedException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::separated('camelString', false);
    }

    /**
     * Tests the String::truncate() function.
     * @depends test_isString
     */
    public function test_truncate()
    {
        $expected = "Winter is ...";
        $output = Str::truncate("Winter is coming!", 10);
        $this->assertEquals($expected, $output);

        $expected = "Winter is ";
        $output = Str::truncate("Winter is coming!", 10, '');
        $this->assertEquals($expected, $output);

        $expected = "<span>Winter is ...</span>";
        $output = Str::truncate("<span>Winter is coming!</span>", 10, '...', true);
        $this->assertEquals($expected, $output);
    }

    /**
     * Tests the String::nsprintf() function.
     * @depends test_isString
     */
    public function test_nsprintf()
    {
        $expected = "This is the name that was replaced: Jon Snow.";
        $output = Str::nsprintf('This is the name that was replaced: %name$s.', array('name' => 'Jon Snow'));
        $this->assertEquals($expected, $output);
    }

    public function test_nsprintfException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::nsprintf(false);
    }

    /**
     * Tests the String::random() function.
     * @depends test_isString
     */
    public function test_random()
    {
        $expected = 10;
        $output = strlen(Str::random($expected));
        $this->assertEquals($expected, $output);
    }

    public function test_randomException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::random(false);
    }

    public function test_randomException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Str::random(10, false);
    }

    /**
     * Tests the String::trandom() function.
     * @depends test_isString
     * @depends test_random
     */
    public function test_trandom()
    {
        $expected = 16;
        $output = strlen(Str::trandom());
        $this->assertEquals($expected, $output);
    }

    public function test_concat()
    {
        $expected = 'Winter is coming!';
        $output = Str::concat('Winter ', 'is ', 'coming', '!');
        $this->assertEquals($expected, $output);

        $expected = 'Some Winterfell characters from Game of Thrones are: Jon Snow, Ned Stark, Arya Stark, Robb Stark.';
        $output = Str::concat('Some Winterfell characters ', 'from Game of Thrones are: ', [
            'Jon Snow, ', 'Ned Stark, ', 'Arya Stark, ', 'Robb Stark.']);
        $this->assertEquals($expected, $output);
    }

    public function test_prepend()
    {
        $expected = 'Winter is coming!';
        $output = Str::prepend('is coming!', 'Winter ');
        $this->assertEquals($expected, $output);

        $expected = ['Jon Snow is son of Ned Stark', 'Robb Stark is son of Ned Stark', 'Brandon Stark is son of Ned Stark'];
        $output = Str::prepend(' is son of Ned Stark', ['Jon Snow', 'Robb Stark', 'Brandon Stark']);
        $this->assertEquals($expected, $output);

        $expected = ['Winter is coming!', 'Winter is upon us!', 'Winter is already here!'];
        $output = Str::prepend([' is coming!', ' is upon us!', ' is already here!'], 'Winter');
        $this->assertEquals($expected, $output);

        $expected = ['1. Jon Snow', '2. Ned Stark', '3. Arya Stark', '4. Robb Stark'];
        $output = Str::prepend(['Jon Snow', 'Ned Stark', 'Arya Stark', 'Robb Stark'], ['1. ', '2. ', '3. ', '4. ']);
        $this->assertEquals($expected, $output);
    }

    public function test_append()
    {
        $expected = 'Winter is coming!';
        $output = Str::append('Winter ', 'is coming!');
        $this->assertEquals($expected, $output);

        $expected = ['Winter is coming!', 'Winter is upon us!', 'Winter is already here!'];
        $output = Str::append('Winter', [' is coming!', ' is upon us!', ' is already here!']);
        $this->assertEquals($expected, $output);

        $expected = ['Jon Snow is son of Ned Stark', 'Robb Stark is son of Ned Stark', 'Brandon Stark is son of Ned Stark'];
        $output = Str::append(['Jon Snow', 'Robb Stark', 'Brandon Stark'], ' is son of Ned Stark');
        $this->assertEquals($expected, $output);

        $expected = ['1. Jon Snow', '2. Ned Stark', '3. Arya Stark', '4. Robb Stark'];
        $output = Str::append(['1. ', '2. ', '3. ', '4. '], ['Jon Snow', 'Ned Stark', 'Arya Stark', 'Robb Stark']);
        $this->assertEquals($expected, $output);
    }
}
