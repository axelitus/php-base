<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.7.1
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
     * Gets a non-public property from a class or instance and sets it as accessible to run tests.
     *
     * @param string $classOrInstance The class or instance that contains the property to get.
     * @param string $propertyName    The property to get.
     *
     * @return \ReflectionProperty The property.
     */
    protected static function getNonPublicProperty($classOrInstance, $propertyName)
    {
        $ref = new \ReflectionClass($classOrInstance);
        $property = $ref->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }

    /**
     * Gets a non-public method from a class or instance and sets it as accessible to run tests.
     *
     * @param string $classOrInstance The class or instance that contains the method to get.
     * @param string $methodName      The method to get.
     *
     * @return \ReflectionMethod The method.
     */
    protected static function getNonPublicMethod($classOrInstance, $methodName)
    {
        $ref = new \ReflectionClass($classOrInstance);
        $method = $ref->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Executes a non-public method from a class or instance.
     *
     * @param string $classOrInstance The class or instance that contains the method to execute.
     * @param string $methodName      The method to execute.
     * @param array  $args            The arguments to pass to the method execution.
     *
     * @return mixed The result of the execution.
     */
    protected static function execNonPublicMethod($classOrInstance, $methodName, array $args = [])
    {
        $method = static::getNonPublicMethod($classOrInstance, $methodName);
        return $method->invokeArgs(null, $args);
    }
}
