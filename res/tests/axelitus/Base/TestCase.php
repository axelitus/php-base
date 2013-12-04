<?php
/**
 * axelitus/base - Primitive extensions and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License (@see LICENSE.md)
 * @package     axelitus\Base
 * @version     0.4
 */

namespace axelitus\Base\Tests;

/**
 * Class TestCase
 *
 * @package axelitus\Base
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var string $class */
    protected $class;

    /**
     * Setup function to configure the tests.
     */
    public function setUp()
    {
        $this->class = str_replace('Tests\Tests', '', get_called_class());
    }

    /**
     * Gets a non-public method from a class and sets it as accessible to run tests.
     *
     * @param string $class      The class that contains the method to get.
     * @param string $methodName The method to get.
     *
     * @return \ReflectionMethod The method.
     */
    protected static function getNonPublicMethod($class, $methodName)
    {
        $ref = new \ReflectionClass($class);
        $method = $ref->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Executes a non-public method from a class.
     *
     * @param string $class      The class that contains the method to execute.
     * @param string $methodName The method to execute.
     * @param array  $args       The arguments to pass to the method execution.
     *
     * @return mixed The result of the execution.
     */
    protected static function execNonPublicMethod($class, $methodName, array $args = [])
    {
        $method = static::getNonPublicMethod($class, $methodName);
        return $method->invokeArgs(null, $args);
    }
}
