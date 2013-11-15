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

    /**
     * Tests Int::random()
     */
    public function test_random()
    {
        $rand = Int::random();
        $output = ($rand >= 0 and $rand <= 1);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(5, 10);
        $output = ($rand >= 5 and $rand <= 10);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(-20, 0);
        $output = ($rand >= -20 and $rand <= 0);
        $this->assertTrue(is_int($rand) and $output);

        $rand = Int::random(150, 250, 10);
        $output = ($rand >= 150 and $rand <= 250);
        $this->assertTrue(is_int($rand) and $output);
        $this->assertEquals(173, $rand);    // Because it's seeded it should give us the same result

        $this->setExpectedException('\InvalidArgumentException');
        Int::random(false);

        $this->setExpectedException('\InvalidArgumentException');
        Int::random(6, false);
    }
}
