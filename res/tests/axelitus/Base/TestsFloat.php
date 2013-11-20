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

namespace axelitus\Base\Tests;

use axelitus\Base\Float;

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
    public function test_isFloat()
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

    /**
     * Tests Float::random()
     */
    public function test_random()
    {
        $rand = Float::random();
        $output = ($rand >= 0 and $rand < 1);
        $this->assertTrue(is_float($rand) and $output);

        $rand = Float::random(5.23, 10.59);
        $output = ($rand >= 5.23 and $rand < 10.59);
        $this->assertTrue(is_float($rand) and $output);

        $rand = Float::random(-20.43, 0.5);
        $output = ($rand >= -20.43 and $rand < 0.5);
        $this->assertTrue(is_float($rand) and $output);

        $rand = Float::random(150.82, 250.21, null, 10);
        $output = ($rand >= 150.82 and $rand < 250.21);
        $this->assertTrue(is_float($rand) and $output);
        $this->assertEquals(174.07007607784, $rand);

        $rand = Float::random(150.82, 250.21, 2, 10);
        $output = ($rand >= 150.82 and $rand < 250.21);
        $this->assertTrue(is_float($rand) and $output);
        $this->assertEquals(174.07, $rand);    // Because it's seeded it should give us the same result (it's rounded)

        $rand = Float::random(150.82, 250.21, 5, 10);
        $output = ($rand >= 150.82 and $rand < 250.21);
        $this->assertTrue(is_float($rand) and $output);
        $this->assertEquals(174.07008, $rand);    // Because it's seeded it should give us the same result (it's rounded)

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $this->assertFalse(@Float::random(6, 3));
    }

    public function test_randomException01()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Float::random(false);
    }

    public function test_randomException02()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Float::random(6, false);
    }
}
