<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.7.2
 */

namespace axelitus\Base;

/**
 * Class PropertyAccessible
 *
 * Allows derived class to use object property access syntax just be defining getters and setters.
 *
 * This class favors convention over configuration. The properties must be explicitly declared.
 * The derived classes are enforced to comply with the PSR-2 coding style guide for the accessors to work.
 *
 * Getter methods naming convention: get{PropertyName}(). If no getter is found the property is not readable.
 * Setter methods naming convention: set{PropertyName}($value). If no setter is found, the property is readonly.
 *
 * To document the properties on the derived class please refer to phpDocumentor's property tag.
 * @see     http://www.phpdoc.org/docs/latest/for-users/phpdoc/tags/property.html
 * @see     http://www.phpdoc.org/docs/latest/for-users/phpdoc/tags/property-read.html
 * @see     http://www.phpdoc.org/docs/latest/for-users/phpdoc/tags/property-write.html
 *
 * @package axelitus\Base
 */
abstract class PropertyAccessible
{
    private $refClass = null;

    /**
     * Gets the ReflectionClass object for the current object.
     *
     * The ReflectionClass object is created only once, then that value is returned for subsequent calls.
     *
     * @return null|\ReflectionClass The ReflectionClass of the object.
     */
    final private function getRefClass()
    {
        if ($this->refClass === null) {
            $this->refClass = new \ReflectionClass($this);
        }

        return $this->refClass;
    }

    /**
     * Gets a ReflectionMethod from the object's ReflectionClass.
     *
     * @param string $method The method to get.
     *
     * @return \ReflectionMethod The ReflectionMethod from the object's ReflectionClass.
     */
    final private function getRefMethod($method)
    {
        return $this->getRefClass()->getMethod($method);
    }

    /**
     * Property magic getter.
     *
     * The function works as expected with private/protected properties/methods and child classes.
     *
     * @param string $property The property to get.
     *
     * @return mixed The value of the property.
     * @throws \RuntimeException
     */
    final public function __get($property)
    {
        if ($this->hasProperty($property)) {
            // if the property is public it is automatically accessible, therefore we don't need to test that
            if ($this->hasMethod(($method = 'get' . Str::ucfirst($property)))
                && $this->getRefMethod($method)->isPublic()
            ) {
                return $this->{$method}();
            } else {
                throw new \RuntimeException("The property '{$property}' is not readable.");
            }
        } else {
            throw new \RuntimeException("The property '{$property}' does not exist.");
        }
    }

    /**
     * Property magic setter.
     *
     * The function works as expected with private/protected properties/methods and child classes.
     *
     * @param string $property The property to set.
     * @param mixed  $value    The value to set to the property.
     *
     * @throws \RuntimeException
     */
    final public function __set($property, $value)
    {
        if ($this->hasProperty($property)) {
            // if the property is public it is automatically accessible, therefore we don't need to test that
            if ($this->hasMethod(($method = 'set' . Str::ucfirst($property)))
                && $this->getRefMethod($method)->isPublic()
            ) {
                $this->{$method}($value);
            } else {
                throw new \RuntimeException("The property '{$property}' is not writeable.");
            }
        } else {
            throw new \RuntimeException("The property '{$property}' does not exist.");
        }
    }

    /**
     * Checks if the object has the given property.
     *
     * @param string $property The property to check.
     *
     * @return bool Returns true if the property exists, false otherwise.
     *
     * @see http://docs.php.net/manual/en/language.variables.basics.php
     * @throws \InvalidArgumentException
     */
    final public function hasProperty($property)
    {
        if (!Str::is($property)
            || !Str::match($property, "/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/")
            || $property == 'this'
        ) {
            throw new \InvalidArgumentException(
                "The \$property parameter must be a string and follow the PHP rules of variable naming."
            );
        }

        return property_exists($this, $property);
    }

    /**
     * Checks if the object has the given method.
     *
     * @param string $method The method to check.
     *
     * @return bool Returns true if the property exists, false otherwise.
     *
     * @see http://docs.php.net/manual/en/function.user-defined.php
     * @throws \InvalidArgumentException
     */
    final public function hasMethod($method)
    {
        if (!Str::is($method)
            || !Str::match($method, "/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/")
        ) {
            throw new \InvalidArgumentException(
                "The \$method parameter must be a string and follow the PHP rules of method naming."
            );
        }

        return method_exists($this, $method);
    }
}
