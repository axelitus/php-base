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

namespace axelitus\Base\Tests;

use axelitus\Base\Tests\PropertyAccessible\PropertyAccessibleDerived;
use axelitus\Base\Tests\PropertyAccessible\PropertyAccessibleDerivedChild;

/**
 * Class TestsPropertyAccesible
 *
 * @package axelitus\Base
 */
class TestsPropertyAccesible extends TestCase
{
    //region Properties

    /** @var \axelitus\Base\PropertyAccessible */
    private $mock;

    /** @var \axelitus\Base\Tests\PropertyAccessible\PropertyAccessibleDerived */
    private $obj;

    /** @var \axelitus\Base\Tests\PropertyAccessible\PropertyAccessibleDerivedChild */
    private $child;

    //endregion

    //region SetUp

    public function setUp()
    {
        $this->mock = $this->getMockForAbstractClass('\axelitus\Base\PropertyAccessible');
        $this->obj = new PropertyAccessibleDerived();
        $this->child = new PropertyAccessibleDerivedChild();
    }

    //endregion

    //region Test has* functions

    public function testHasPropertyEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$property parameter must be a string and follow the PHP rules of variable naming."
        );
        $this->mock->hasProperty(false);
    }

    public function testHasMethodEx01()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            "The \$method parameter must be a string and follow the PHP rules of method naming."
        );
        $this->mock->hasMethod(false);
    }

    //endregion

    //region Get Raw Properties

    public function testGetPrivateRawProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateRawProperty' is not readable.");
        $this->assertEquals('private raw property', $this->obj->privateRawProperty);
    }

    public function testGetProtectedRawProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'protectedRawProperty' is not readable.");
        $this->assertEquals('protected raw property', $this->obj->protectedRawProperty);
    }

    public function testGetPublicRawProperty()
    {
        $this->assertEquals('public raw property', $this->obj->publicRawProperty);
    }

    //endregion

    //region Set Raw Properties

    public function testSetPrivateRawProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateRawProperty' is not writeable.");
        $this->obj->privateRawProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'privateRawProperty'));
    }

    public function testSetProtectedRawProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'protectedRawProperty' is not writeable.");
        $this->obj->protectedRawProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'protectedRawProperty'));
    }

    public function testSetPublicRawProperty()
    {
        $this->obj->publicRawProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'publicRawProperty'));
    }

    //endregion

    //region Get Properties with Getter

    public function testGetPrivateGSProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateGSProperty' is not readable.");
        $this->assertEquals('private getter/setter property', $this->obj->privateGSProperty);
    }

    public function testGetProtectedGSProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'protectedGSProperty' is not readable.");
        $this->assertEquals('protected getter/setter property', $this->obj->protectedGSProperty);
    }

    public function testGetPublicGSProperty()
    {
        $this->assertEquals('public getter/setter property', $this->obj->publicGSProperty);
    }

    //endregion

    //region Set Properties with Getter

    public function testSetPrivateGSProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateGSProperty' is not writeable.");
        $this->obj->privateGSProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'privateGSProperty'));
    }

    public function testSetProtectedGSProperty()
    {
        $this->setExpectedException('\RuntimeException', "The property 'protectedGSProperty' is not writeable.");
        $this->obj->protectedGSProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'protectedGSProperty'));
    }

    public function testSetPublicGSProperty()
    {
        $this->obj->publicGSProperty = 'changed';
        $this->assertEquals('changed', static::getNonPublicPropertyValue($this->obj, 'publicGSProperty'));
    }

    //endregion

    //region Get Non-existent

    public function testGetNonExistent()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The property 'nonExistent' does not exist."
        );
        $this->assertEquals(null, $this->obj->nonExistent);
    }

    //endregion

    //region Set Non-existent

    public function testSetNonExistent()
    {
        $this->setExpectedException(
            '\RuntimeException',
            "The property 'nonExistent' does not exist."
        );
        $this->obj->nonExistent = null;
    }

    //endregion

    //region Get Properties from Child

    public function getPrivateRawPropertyFromChild()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateRawProperty' is not readable.");
        $this->assertEquals('private raw property', $this->child->privateRawProperty);
    }

    public function getProtectedRawPropertyFromChild()
    {
        $this->assertEquals('protected raw property', $this->child->protectedRawProperty);
    }

    public function getPublicRawPropertyFromChild()
    {
        $this->assertEquals('public raw property', $this->child->publicRawProperty);
    }

    public function getPrivateGSPropertyFromChild()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateGSProperty' is not readable.");
        $this->assertEquals('private getter/setter property', $this->child->privateGSProperty);
    }

    public function getProtectedGSPropertyFromChild()
    {
        $this->assertEquals('protected getter/setter property', $this->child->protectedGSProperty);
    }

    public function getPublicGSPropertyFromChild()
    {
        $this->assertEquals('public getter/setter property', $this->child->publicGSProperty);
    }

    //endregion

    //region Set Properties from Child

    public function setPrivateRawPropertyFromChild()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateRawProperty' is not readable.");
        $this->child->privateRawProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'privateRawProperty')
        );
    }

    public function setProtectedRawPropertyFromChild()
    {
        $this->child->protectedRawProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'protectedRawProperty')
        );
    }

    public function setPublicRawPropertyFromChild()
    {
        $this->child->publicRawProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'publicRawProperty')
        );
    }

    public function setPrivateGSPropertyFromChild()
    {
        $this->setExpectedException('\RuntimeException', "The property 'privateGSProperty' is not readable.");
        $this->child->privateGSProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'privateGSProperty')
        );
    }

    public function setProtectedGSPropertyFromChild()
    {
        $this->child->protectedGSProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'protectedGSProperty')
        );
    }

    public function setPublicGSPropertyFromChild()
    {
        $this->child->publicGSProperty = 'changed';
        $this->assertEquals(
            'changed',
            static::getNonPublicPropertyValue($this->child, 'publicGSProperty')
        );
    }

    //endregion
}
