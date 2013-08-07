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
    public function test_length()
    {
        $this->assertEquals(33, String::length("This is a 33 chars length string."), "The length is not correctly calculated.");
        $this->assertEquals(83, String::length("This string, however, is a little bit longer, having in total a length of 83 chars."), "The length is not correctly calculated.");
    }
}
